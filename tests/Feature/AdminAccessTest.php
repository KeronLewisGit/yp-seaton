<?php

namespace Tests\Feature;

use App\Enums\Role;
use App\Enums\TenderStatus;
use App\Enums\VendorStatus;
use App\Models\DocumentRoom;
use App\Models\Enquiry;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\Tender;
use App\Models\User;
use App\Models\Vendor;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/tenders')->assertRedirect('/login');
    }

    public function test_login_and_inactive_accounts(): void
    {
        $user = User::factory()->create(['email' => 'est@example.com']);
        $this->post('/login', ['email' => 'EST@example.com', 'password' => 'password'])->assertRedirect('/admin');
        $user->update(['active' => false]);
        $this->app['auth']->forgetGuards(); // the next request loads the user afresh, as a real one would
        $this->get('/admin')->assertRedirect('/login');
        $this->assertGuest();
        $this->post('/login', ['email' => 'est@example.com', 'password' => 'password'])->assertSessionHasErrors('email');
    }

    /** @return array<string, array{Role, array<string, int>}> */
    public static function matrix(): array
    {
        return [
            'admin' => [Role::Admin, ['/admin/tenders' => 200, '/admin/vendors' => 200, '/admin/applications' => 200, '/admin/jobs' => 200, '/admin/enquiries' => 200, '/admin/rooms' => 200, '/admin/users' => 200]],
            'estimating' => [Role::Estimating, ['/admin/tenders' => 200, '/admin/vendors' => 403, '/admin/applications' => 403, '/admin/jobs' => 403, '/admin/enquiries' => 200, '/admin/rooms' => 200, '/admin/users' => 403]],
            'procurement' => [Role::Procurement, ['/admin/tenders' => 403, '/admin/vendors' => 200, '/admin/applications' => 403, '/admin/jobs' => 403, '/admin/enquiries' => 403, '/admin/rooms' => 403, '/admin/users' => 403]],
            'hr' => [Role::Hr, ['/admin/tenders' => 403, '/admin/vendors' => 403, '/admin/applications' => 200, '/admin/jobs' => 200, '/admin/enquiries' => 403, '/admin/rooms' => 403, '/admin/users' => 403]],
        ];
    }

    /** @param array<string, int> $expect */
    #[DataProvider('matrix')]
    public function test_each_role_sees_only_its_areas(Role $role, array $expect): void
    {
        $this->actingAs($this->staff($role));
        $this->get('/admin')->assertOk();
        foreach ($expect as $url => $status) {
            $this->get($url)->assertStatus($status);
        }
    }

    public function test_dashboard_leads_with_the_number_for_the_role(): void
    {
        Tender::factory()->dueIn(3)->count(2)->create();
        Tender::factory()->dueIn(30)->create();
        $this->actingAs($this->staff(Role::Estimating))->get('/admin')->assertSee('tender submissions are due in the next 7 days')->assertSee('>02<', false);

        Vendor::factory()->approved()->withCertificates(10)->create();
        $this->actingAs($this->staff(Role::Procurement))->get('/admin')->assertSee('certificates have expired or expire within 30 days')->assertSee('>03<', false);

        JobApplication::factory()->create(['created_at' => now()->subDays(5)]);
        $this->actingAs($this->staff(Role::Hr))->get('/admin')->assertSee('application has waited more than 3 days');
    }

    public function test_tender_status_assignment_and_notes(): void
    {
        $est = $this->staff(Role::Estimating);
        $hr = $this->staff(Role::Hr);
        $tender = Tender::factory()->create();
        $this->actingAs($est);

        $this->patch(route('admin.tenders.update', $tender), ['status' => 'submitted', 'assigned_to' => $est->id])->assertRedirect();
        $tender->refresh();
        $this->assertSame(TenderStatus::Submitted, $tender->status);
        $this->assertNotNull($tender->submitted_at);
        $this->assertSame($est->id, $tender->assigned_to);

        $this->patch(route('admin.tenders.update', $tender), ['assigned_to' => $hr->id])->assertSessionHasErrors('assigned_to');
        $this->post(route('admin.tenders.note', $tender), ['body' => 'Site visit booked'])->assertRedirect();
        $this->get(route('admin.tenders.show', $tender))->assertSee('Site visit booked')->assertSee('Status changed to Bid submitted.');
    }

    public function test_tender_files_open_only_for_estimating_and_admin(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('tenders/1/itb.pdf', 'pdf');
        $tender = Tender::factory()->create();
        $file = $tender->files()->create(['path' => 'tenders/1/itb.pdf', 'original_name' => 'ITB.pdf', 'mime' => 'application/pdf', 'size' => 3]);
        $other = Tender::factory()->create();

        $this->actingAs($this->staff(Role::Procurement))->get(route('admin.tenders.file', [$tender, $file]))->assertForbidden();
        $this->actingAs($this->staff(Role::Estimating))->get(route('admin.tenders.file', [$other, $file]))->assertForbidden();
        $this->actingAs($this->staff(Role::Admin))->get(route('admin.tenders.file', [$tender, $file]))->assertOk()->assertHeader('Cache-Control', 'no-store, private');
        $this->assertSame(1, $tender->notes()->where('kind', 'file')->count());
    }

    public function test_vendor_certificates_open_only_for_procurement_and_admin(): void
    {
        Storage::fake('local');
        $vendor = Vendor::factory()->withCertificates()->create();
        $doc = $vendor->documents()->firstOrFail();
        Storage::disk('local')->put($doc->path, 'pdf');
        $other = Vendor::factory()->create();

        $this->actingAs($this->staff(Role::Hr))->get(route('admin.vendors.document', [$vendor, $doc]))->assertForbidden();
        $this->actingAs($this->staff(Role::Estimating))->get(route('admin.vendors.document', [$vendor, $doc]))->assertForbidden();
        $this->actingAs($this->staff(Role::Procurement))->get(route('admin.vendors.document', [$other, $doc]))->assertForbidden();
        $this->actingAs($this->staff(Role::Procurement))->get(route('admin.vendors.document', [$vendor, $doc]))->assertOk();
        $this->assertTrue($vendor->notes()->where('kind', 'file')->exists());
    }

    public function test_cvs_open_only_for_hr_and_admin(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('cvs/a.pdf', 'cv');
        $a = JobApplication::factory()->create(['cv_path' => 'cvs/a.pdf', 'cv_name' => 'cv.pdf']);
        $b = JobApplication::factory()->create();

        $this->actingAs($this->staff(Role::Estimating))->get(route('admin.applications.cv', $a))->assertForbidden();
        $this->actingAs($this->staff(Role::Procurement))->get(route('admin.applications.cv', $a))->assertForbidden();
        $this->actingAs($this->staff(Role::Hr))->get(route('admin.applications.cv', $a))->assertOk();
        $this->actingAs($this->staff(Role::Hr))->get(route('admin.applications.cv', $b))->assertForbidden();
        $this->actingAs($this->staff(Role::Admin))->get(route('admin.applications.cv', $a))->assertOk();
    }

    public function test_a_vendor_cannot_be_approved_with_an_expired_or_missing_certificate(): void
    {
        $this->actingAs($this->staff(Role::Procurement));
        $vendor = Vendor::factory()->withCertificates()->create();
        $vendor->documents()->where('kind', 'insurance')->update(['expires_on' => today()->subDay()]);
        $this->patch(route('admin.vendors.update', $vendor), ['status' => 'approved'])->assertSessionHasErrors('status');
        $this->assertSame(VendorStatus::New, $vendor->refresh()->status);

        $vendor->documents()->where('kind', 'insurance')->update(['expires_on' => today()->addYear()]);
        $this->patch(route('admin.vendors.update', $vendor), ['status' => 'approved'])->assertSessionHasNoErrors();
        $this->assertSame(VendorStatus::Approved, $vendor->refresh()->status);
        $this->assertNotNull($vendor->approved_at);
    }

    public function test_verifying_a_certificate_records_who_and_when(): void
    {
        $user = $this->staff(Role::Procurement);
        $vendor = Vendor::factory()->withCertificates()->create();
        $doc = $vendor->documents()->firstOrFail();
        $this->actingAs($user)->patch(route('admin.vendors.verify', [$vendor, $doc]), ['expires_on' => today()->addDays(90)->format('Y-m-d'), 'number' => 'TCC-99'])->assertRedirect();
        $doc->refresh();
        $this->assertSame($user->id, $doc->verified_by);
        $this->assertSame('TCC-99', $doc->number);
    }

    public function test_csv_exports_are_formula_safe(): void
    {
        Tender::factory()->create(['entity_name' => '=HYPERLINK("x")']);
        $csv = $this->actingAs($this->staff(Role::Estimating))->get(route('admin.tenders.export'))->assertOk()->streamedContent();
        $this->assertStringContainsString("'=HYPERLINK", $csv);
        Vendor::factory()->withCertificates()->create(['company_name' => '+cmd']);
        $csv = $this->actingAs($this->staff(Role::Procurement))->get(route('admin.vendors.export'))->streamedContent();
        $this->assertStringContainsString("'+cmd", $csv);
        $this->actingAs($this->staff(Role::Hr))->get(route('admin.applications.export'))->assertOk();
    }

    public function test_every_admin_screen_renders_with_data(): void
    {
        $this->seed(DemoSeeder::class);
        $admin = User::where('email', 'admin@ypseaton.test')->firstOrFail();
        $this->actingAs($admin);
        $urls = ['/admin', '/admin/tenders', '/admin/tenders?status=open', '/admin/tenders?due=1', '/admin/vendors', '/admin/vendors?renewal=1', '/admin/applications', '/admin/jobs', '/admin/jobs/create', '/admin/enquiries', '/admin/rooms', '/admin/users'];
        $urls[] = route('admin.tenders.show', Tender::firstOrFail());
        $urls[] = route('admin.vendors.show', Vendor::firstOrFail());
        $urls[] = route('admin.applications.show', JobApplication::firstOrFail());
        $urls[] = route('admin.jobs.edit', JobPosting::firstOrFail());
        $urls[] = route('admin.enquiries.show', Enquiry::firstOrFail());
        $urls[] = route('admin.rooms.show', DocumentRoom::firstOrFail());
        foreach ($urls as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_job_postings_crud(): void
    {
        $this->actingAs($this->staff(Role::Hr));
        $this->post(route('admin.jobs.store'), ['title' => 'Steel Fixer', 'category' => 'trades', 'employment_type' => 'project', 'status' => 'open', 'location' => 'Kingston', 'openings' => 4, 'summary' => 'Fix rebar.'])
            ->assertRedirect(route('admin.jobs.index'));
        $job = JobPosting::sole();
        $this->assertSame('steel-fixer', $job->slug);
        $this->put(route('admin.jobs.update', $job), ['title' => 'Steel Fixer', 'category' => 'trades', 'employment_type' => 'project', 'status' => 'closed', 'location' => 'Kingston', 'openings' => 4, 'summary' => 'Fix rebar.'])->assertRedirect();
        $this->get('/careers/steel-fixer')->assertNotFound();
    }

    public function test_staff_management_is_admin_only_and_admins_keep_their_access(): void
    {
        $admin = $this->staff(Role::Admin);
        $this->actingAs($admin)->post(route('admin.users.store'), ['name' => 'Hr Person', 'email' => 'HR@x.com', 'role' => 'hr', 'password' => 'long-password'])->assertRedirect();
        $this->assertSame(Role::Hr, User::where('email', 'hr@x.com')->firstOrFail()->role);
        $this->patch(route('admin.users.update', $admin), ['role' => 'hr', 'active' => '1'])->assertSessionHasErrors('role');
        $this->actingAs($this->staff(Role::Hr))->post(route('admin.users.store'), [])->assertForbidden();
    }

    public function test_a_refused_assignment_leaves_the_status_unchanged(): void
    {
        $est = $this->staff(Role::Estimating);
        $hr = $this->staff(Role::Hr);
        $tender = Tender::factory()->create();

        $this->actingAs($est)->patch(route('admin.tenders.update', $tender), ['status' => 'pricing', 'assigned_to' => $hr->id])->assertSessionHasErrors('assigned_to');
        $this->assertSame(TenderStatus::New, $tender->refresh()->status);
        $this->assertFalse($tender->notes()->where('kind', 'status')->exists(), 'no timeline entry for a change that was not saved');
    }

    public function test_correcting_a_certificate_expiry_rearms_its_reminder(): void
    {
        $vendor = Vendor::factory()->approved()->withCertificates(10)->create();
        $doc = $vendor->documents()->where('kind', 'tcc')->firstOrFail();
        $doc->update(['reminded_at' => now()]);
        $this->actingAs($this->staff(Role::Procurement));

        // Checked with the same date: the reminder already sent still counts.
        $this->patch(route('admin.vendors.verify', [$vendor, $doc]), ['expires_on' => $doc->expires_on?->format('Y-m-d')])->assertRedirect();
        $this->assertNotNull($doc->refresh()->reminded_at);

        // A new date gets its own reminder when it comes round.
        $this->patch(route('admin.vendors.verify', [$vendor, $doc]), ['expires_on' => today()->addYear()->format('Y-m-d')])->assertRedirect();
        $this->assertNull($doc->refresh()->reminded_at);
    }

    public function test_supporting_documents_are_checked_without_an_expiry(): void
    {
        $vendor = Vendor::factory()->withCertificates()->create();
        $other = $vendor->documents()->create(['kind' => 'other', 'path' => 'vendors/x/other.pdf', 'original_name' => 'nis.pdf', 'mime' => 'application/pdf', 'size' => 10]);
        $this->actingAs($this->staff(Role::Procurement))->patch(route('admin.vendors.verify', [$vendor, $other]), ['expires_on' => '2020-01-01'])->assertRedirect();
        $this->assertNull($other->refresh()->expires_on);
        $this->assertNotNull($other->verified_at);
    }

    public function test_a_posting_titled_apply_does_not_hide_behind_the_application_form(): void
    {
        $this->actingAs($this->staff(Role::Hr));
        $this->post(route('admin.jobs.store'), ['title' => 'Apply', 'category' => 'trades', 'employment_type' => 'project', 'status' => 'open', 'location' => 'Kingston', 'openings' => 1, 'summary' => 'Any trade.'])->assertRedirect();
        $job = JobPosting::sole();
        $this->assertNotSame('apply', $job->slug);
        $this->get(route('careers.show', $job))->assertOk()->assertSee('Any trade.');
    }

    public function test_staff_email_is_unique_whatever_the_case(): void
    {
        $admin = $this->staff(Role::Admin);
        $existing = $this->staff(Role::Hr);
        $this->actingAs($admin)->post(route('admin.users.store'), ['name' => 'Dup', 'email' => strtoupper($existing->email), 'role' => 'hr', 'password' => 'long-password'])
            ->assertSessionHasErrors('email');
        $this->assertSame(1, User::where('email', $existing->email)->count());
    }

    public function test_admin_forms_survive_junk_array_input(): void
    {
        $this->actingAs($this->staff(Role::Admin));
        $this->from(route('admin.rooms.index'))->post(route('admin.rooms.store'), ['name' => ['x'], 'client_name' => ['y']])->assertSessionHasErrors(['name', 'client_name']);
        $this->get(route('admin.rooms.index'))->assertOk();
    }

    public function test_enquiry_status(): void
    {
        $e = Enquiry::create(['topic' => 'general', 'name' => 'A', 'email' => 'a@example.com', 'message' => 'Hello there team']);
        $this->actingAs($this->staff(Role::Estimating))->patch(route('admin.enquiries.update', $e), ['status' => 'answered', 'body' => 'Called back'])->assertRedirect();
        $this->assertSame('answered', $e->refresh()->status->value);
        $this->assertSame(2, $e->notes()->count());
    }

    public function test_an_approval_sent_twice_at_once_is_applied_once(): void
    {
        $officer = $this->staff(Role::Procurement);
        $vendor = Vendor::factory()->withCertificates()->create();
        // Two requests that loaded the vendor before either saved.
        $first = Vendor::findOrFail($vendor->id);
        $second = Vendor::findOrFail($vendor->id);

        $this->assertTrue($first->claimStatus(VendorStatus::Approved, $officer));
        $this->assertFalse($second->claimStatus(VendorStatus::Approved, $officer));
        $this->assertSame(VendorStatus::Approved, $vendor->refresh()->status);
        $this->assertSame($officer->id, $vendor->reviewed_by);

        // Through the controller: the second identical request adds no second timeline entry.
        $this->actingAs($officer);
        $this->patch(route('admin.vendors.update', $vendor), ['status' => 'reviewing'])->assertRedirect();
        $this->patch(route('admin.vendors.update', $vendor), ['status' => 'reviewing'])->assertRedirect();
        $this->assertSame(1, $vendor->notes()->where('kind', 'status')->count());
    }

    public function test_a_tender_status_change_sent_twice_at_once_is_applied_once(): void
    {
        $tender = Tender::factory()->create();
        $first = Tender::findOrFail($tender->id);
        $second = Tender::findOrFail($tender->id);
        $this->assertTrue($first->claimStatus(TenderStatus::Submitted));
        $this->assertFalse($second->claimStatus(TenderStatus::Submitted));
        $this->assertNotNull($tender->refresh()->submitted_at);
    }
}
