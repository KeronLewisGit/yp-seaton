<?php

namespace Tests\Feature;

use App\Enums\DocumentKind;
use App\Enums\VendorStatus;
use App\Models\Vendor;
use App\Notifications\CertificateExpiring;
use App\Notifications\SubmissionReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class PrequalFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, mixed> */
    private function form(string $type = 'subcontractor', array $overrides = []): array
    {
        $doc = fn (string $name, int $days = 120) => ['file' => UploadedFile::fake()->create($name, 200, 'application/pdf'), 'number' => 'N-1', 'expires_on' => today()->addDays($days)->format('Y-m-d')];

        return array_replace_recursive([
            'type' => $type,
            'company_name' => 'Sample Formwork Ltd.',
            'trn' => '123-456-789',
            'address' => '10 Sample Avenue',
            'parish' => 'St. Andrew',
            'contact_name' => 'Kemar Brown',
            'email' => 'kemar@example.com',
            'phone' => '876-555-'.random_int(1000, 9999), // a fresh number each time: forms allow 5 a minute per phone
            'trades' => ['formwork', 'concrete'],
            'consent' => '1',
            'docs' => ['tcc' => $doc('tcc.pdf'), 'registration' => $doc('ncc.pdf', 300), 'insurance' => $doc('insurance.pdf', 200)],
        ], $overrides);
    }

    public function test_a_subcontractor_prequalifies_with_three_certificates(): void
    {
        Storage::fake('local');
        Notification::fake();

        $this->post('/prequalification', $this->form())->assertRedirect('/thanks');

        $vendor = Vendor::sole();
        $this->assertSame(sprintf('PQ-%s-%05d', now()->format('y'), $vendor->id), $vendor->reference);
        $this->assertSame('123456789', $vendor->trn);
        $this->assertSame(VendorStatus::New, $vendor->status);
        $this->assertNotNull($vendor->consented_at);
        $this->assertCount(3, $vendor->currentDocuments);
        $this->assertSame('valid', $vendor->complianceState());
        foreach ($vendor->documents as $d) {
            Storage::disk('local')->assertExists($d->path);
        }
        $this->assertSame(today()->addDays(120)->toDateString(), $vendor->current(DocumentKind::Tcc)?->expires_on?->toDateString());
        Notification::assertSentOnDemand(SubmissionReceived::class);
    }

    public function test_a_supplier_needs_no_contractor_registration(): void
    {
        Storage::fake('local');
        $form = $this->form('supplier');
        unset($form['docs']['registration']);
        $this->post('/prequalification', $form)->assertRedirect('/thanks')->assertSessionHasNoErrors();
        $this->assertSame('valid', Vendor::sole()->complianceState());
    }

    public function test_missing_or_expired_certificates_are_refused(): void
    {
        Storage::fake('local');
        $form = $this->form();
        unset($form['docs']['registration']);
        $this->post('/prequalification', $form)->assertSessionHasErrors('docs.registration.file');

        $this->post('/prequalification', $this->form('subcontractor', ['docs' => ['tcc' => ['expires_on' => today()->subDay()->format('Y-m-d')]]]))
            ->assertSessionHasErrors(['docs.tcc.expires_on' => 'This TCC has expired. Upload the current certificate.']);
        $this->post('/prequalification', $this->form('subcontractor', ['trn' => '12345']))->assertSessionHasErrors('trn');
        $this->post('/prequalification', $this->form('subcontractor', ['trades' => ['nonsense']]))->assertSessionHasErrors('trades.0');
        $this->post('/prequalification', $this->form('subcontractor', ['consent' => null]))->assertSessionHasErrors('consent');
        $this->post('/prequalification', $this->form('subcontractor', ['docs' => ['tcc' => ['file' => UploadedFile::fake()->create('x.docx', 10)]]]))->assertSessionHasErrors('docs.tcc.file');
        $this->assertSame(0, Vendor::count());
    }

    public function test_reminder_emails_a_signed_renewal_link_once(): void
    {
        Notification::fake();
        $vendor = Vendor::factory()->approved()->withCertificates(20)->create();
        Vendor::factory()->withCertificates(20)->create(); // not approved: no reminder
        Vendor::factory()->approved()->withCertificates(200)->create(); // not due

        $this->artisan('app:remind-expiring')->assertSuccessful();
        Notification::assertSentOnDemandTimes(CertificateExpiring::class, 1);
        Notification::assertSentOnDemand(CertificateExpiring::class, function (CertificateExpiring $n, $ch, $notifiable) use ($vendor) {
            return $notifiable->routes['mail'] === [$vendor->email] && $n->documents->count() === 3 && str_contains($n->renewUrl, 'signature=');
        });
        $this->assertNotNull($vendor->documents()->first()?->reminded_at);

        $this->artisan('app:remind-expiring')->assertSuccessful();
        Notification::assertSentOnDemandTimes(CertificateExpiring::class, 1);
    }

    public function test_renewal_link_replaces_the_certificate_and_keeps_the_old_copy(): void
    {
        Storage::fake('local');
        Notification::fake();
        $vendor = Vendor::factory()->approved()->withCertificates(10)->create();
        $this->assertSame('expiring', $vendor->complianceState());

        $this->get(route('prequal.renew', $vendor))->assertForbidden();
        $url = $vendor->renewalUrl($vendor->currentDocuments);
        $page = $this->get($url)->assertOk()->assertSee($vendor->company_name)->assertHeader('Referrer-Policy', 'no-referrer');
        preg_match('/action="([^"]+renew[^"]+)"/', (string) $page->getContent(), $m);
        $action = html_entity_decode($m[1]);

        $this->post($action, ['docs' => ['tcc' => ['file' => UploadedFile::fake()->create('tcc-2027.pdf', 100, 'application/pdf'), 'expires_on' => today()->addMonths(6)->format('Y-m-d')]]])
            ->assertRedirect('/thanks');

        $vendor->refresh()->load('currentDocuments');
        $this->assertSame(today()->addMonths(6)->toDateString(), $vendor->current(DocumentKind::Tcc)?->expires_on?->toDateString());
        $this->assertSame(1, $vendor->documents()->whereNotNull('superseded_at')->count());
        $this->post(route('prequal.renew.store', $vendor), [])->assertForbidden();
    }

    public function test_renewal_needs_at_least_one_file(): void
    {
        $vendor = Vendor::factory()->approved()->withCertificates(10)->create();
        $for = $vendor->documents()->pluck('id')->implode('.');
        $action = URL::temporarySignedRoute('prequal.renew.store', now()->addHour(), ['vendor' => $vendor, 'for' => $for]);
        $this->post($action, ['docs' => ['tcc' => ['number' => 'x']]])->assertSessionHasErrors('docs');
    }

    /** Opens the renewal page from $url and returns the signed form action on it. */
    private function renewalAction(string $url): string
    {
        $page = $this->get($url)->assertOk();
        preg_match('/action="([^"]+renew[^"]+)"/', (string) $page->getContent(), $m);

        return html_entity_decode($m[1]);
    }

    public function test_a_renewal_link_stops_working_once_its_certificates_are_renewed(): void
    {
        Storage::fake('local');
        Notification::fake();
        $vendor = Vendor::factory()->approved()->withCertificates(10)->create();
        $tcc = $vendor->documents()->where('kind', 'tcc')->get();
        $url = $vendor->renewalUrl($tcc);
        $renewal = fn () => ['docs' => ['tcc' => ['file' => UploadedFile::fake()->create('tcc.pdf', 100, 'application/pdf'), 'expires_on' => today()->addYear()->format('Y-m-d')]]];

        $action = $this->renewalAction($url);
        $this->post($action, $renewal())->assertRedirect('/thanks');

        // The same email cannot replace the certificate again.
        $this->get($url)->assertForbidden()->assertSee('already been used');
        $this->post($action, $renewal())->assertForbidden();
        $this->assertSame(2, $vendor->documents()->where('kind', 'tcc')->count());
    }

    public function test_a_renewal_link_names_its_certificates_and_expires(): void
    {
        $vendor = Vendor::factory()->approved()->withCertificates(10)->create();
        $other = Vendor::factory()->approved()->withCertificates(10)->create();

        // A link without the certificates it was sent for, or for another vendor's, is refused.
        $this->get(URL::temporarySignedRoute('prequal.renew', now()->addDay(), ['vendor' => $vendor]))->assertForbidden();
        $this->get(URL::temporarySignedRoute('prequal.renew', now()->addDay(), ['vendor' => $vendor, 'for' => $other->documents()->value('id')]))->assertForbidden();
        $this->get($vendor->renewalUrl($vendor->currentDocuments, now()->subMinute()))->assertForbidden();

        // The form on the page is signed for as long as the emailed link, not two hours.
        $until = now()->addDays(Vendor::RENEWAL_LINK_DAYS);
        $action = $this->renewalAction($vendor->renewalUrl($vendor->currentDocuments, $until));
        parse_str((string) parse_url($action, PHP_URL_QUERY), $q);
        $this->assertSame($until->getTimestamp(), (int) $q['expires']);
    }

    public function test_a_declined_vendor_cannot_use_a_renewal_link(): void
    {
        $vendor = Vendor::factory()->approved()->withCertificates(10)->create();
        $url = $vendor->renewalUrl($vendor->currentDocuments);
        $vendor->update(['status' => VendorStatus::Declined]);

        $this->get($url)->assertForbidden()->assertSee('no longer active');
    }

    public function test_supporting_documents_never_expire_or_trigger_reminders(): void
    {
        Storage::fake('local');
        Notification::fake();
        $form = $this->form(overrides: ['docs' => ['other' => ['file' => UploadedFile::fake()->create('nis.pdf', 50, 'application/pdf'), 'expires_on' => '2020-01-01']]]);
        $this->post('/prequalification', $form)->assertRedirect('/thanks');
        $vendor = Vendor::sole();
        $this->assertNull($vendor->current(DocumentKind::Other)?->expires_on);

        // Even a dated "other" document on an approved vendor is not chased.
        $vendor->update(['status' => VendorStatus::Approved]);
        $vendor->documents()->where('kind', 'other')->update(['expires_on' => today()->subYear()]);
        $this->assertSame(0, Vendor::needsRenewal()->count());
        $this->artisan('app:remind-expiring')->assertSuccessful();
        Notification::assertSentOnDemandTimes(CertificateExpiring::class, 0);
    }

    public function test_compliance_states(): void
    {
        $vendor = Vendor::factory()->approved()->withCertificates(200)->create();
        $this->assertSame('valid', $vendor->complianceState());
        $vendor->documents()->where('kind', 'insurance')->update(['expires_on' => today()->subDay()]);
        $this->assertSame('expired', $vendor->refresh()->complianceState());
        $vendor->documents()->where('kind', 'tcc')->delete();
        $this->assertSame('missing', $vendor->refresh()->complianceState());
        $this->assertSame(1, Vendor::needsRenewal()->count());
    }

    public function test_junk_array_input_redisplays_the_prequalification_form(): void
    {
        $junk = ['type' => ['x'], 'company_name' => ['y'], 'trades' => 'earthworks', 'parishes_served' => [['x']], 'docs' => ['tcc' => ['number' => ['x'], 'expires_on' => ['x']]]];
        $this->from('/prequalification')->post('/prequalification', $junk)->assertRedirect('/prequalification')->assertSessionHasErrors(['type', 'company_name', 'trades']);
        $this->followingRedirects()->from('/prequalification')->post('/prequalification', $junk)->assertOk()->assertSee('Please check');
    }
}
