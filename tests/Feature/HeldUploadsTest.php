<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\Tender;
use App\Models\Vendor;
use App\Support\HeldUploads;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/** A form that comes back with an error keeps the files that were fine; nobody attaches them twice. */
class HeldUploadsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        Notification::fake();
    }

    /** A small file with real PDF bytes, so its type is recognised from its content. */
    private function pdf(string $name): UploadedFile
    {
        return UploadedFile::fake()->createWithContent($name, "%PDF-1.4\n1 0 obj << >> endobj\ntrailer << >>\n%%EOF\n");
    }

    /** @return array<string, mixed> */
    private function tender(array $overrides = []): array
    {
        return array_merge([
            'sector' => 'public', 'entity_name' => 'Sample Water Authority', 'contact_name' => 'Andre Campbell', 'email' => 'p@example.org',
            'phone' => '(876) 555-0101', 'title' => 'Lift station', 'method' => 'open', 'scope' => 'Civil works.',
            'due_date' => today()->addDays(12)->format('Y-m-d'), 'due_time' => '14:00',
        ], $overrides);
    }

    public function test_tender_documents_survive_a_validation_error(): void
    {
        $files = [$this->pdf('itb.pdf'), $this->pdf('boq.pdf')];
        $this->from('/tenders')->post('/tenders', $this->tender(['title' => '', 'files' => $files]))->assertSessionHasErrors('title');
        $this->assertCount(2, Storage::disk('local')->allFiles(HeldUploads::DIR));
        $this->get('/tenders')->assertSee('Attached:')->assertSee('itb.pdf, boq.pdf');

        // Sent again with the input left empty: the held files go with it, then are cleared.
        $this->post('/tenders', $this->tender())->assertRedirect('/thanks');
        $tender = Tender::sole();
        $this->assertSame(['boq.pdf', 'itb.pdf'], $tender->files()->orderBy('original_name')->pluck('original_name')->all());
        foreach ($tender->files as $f) {
            Storage::disk('local')->assertExists($f->path);
            $this->assertStringStartsWith('tenders/'.$tender->id.'/', $f->path);
        }
        $this->assertSame([], Storage::disk('local')->allFiles(HeldUploads::DIR));
        $this->assertNull(session('held_uploads.tender'));
    }

    public function test_a_rejected_file_is_not_held_and_a_new_choice_replaces_the_held_one(): void
    {
        $this->post('/tenders', $this->tender(['title' => '', 'files' => [UploadedFile::fake()->create('virus.exe', 10)]]))->assertSessionHasErrors(['title', 'files.0']);
        $this->assertSame([], Storage::disk('local')->allFiles(HeldUploads::DIR));

        $this->post('/tenders', $this->tender(['title' => '', 'files' => [$this->pdf('old.pdf')]]));
        $this->post('/tenders', $this->tender(['title' => '', 'files' => [$this->pdf('new.pdf')]]));
        $this->assertSame(['new.pdf'], HeldUploads::names('tender', 'files'));
        $this->assertCount(1, Storage::disk('local')->allFiles(HeldUploads::DIR));
    }

    public function test_prequalification_certificates_survive_a_validation_error(): void
    {
        $doc = fn (string $n) => ['file' => $this->pdf($n), 'expires_on' => today()->addYear()->format('Y-m-d')];
        $form = [
            'type' => 'subcontractor', 'company_name' => 'Sample Formwork Ltd.', 'trn' => '123456789', 'address' => '1 Road', 'parish' => 'Kingston',
            'contact_name' => 'Kemar Brown', 'email' => 'k@example.com', 'phone' => '876-555-0199', 'trades' => ['formwork'], 'consent' => '1',
        ];
        $this->from('/prequalification')->post('/prequalification', array_merge($form, ['trn' => '12']) + ['docs' => ['tcc' => $doc('tcc.pdf'), 'registration' => $doc('ncc.pdf'), 'insurance' => $doc('ins.pdf')]])
            ->assertSessionHasErrors('trn');
        $page = $this->get('/prequalification')->assertSee('Attached:')->assertSee('tcc.pdf');
        // The browser must not demand the held certificates again.
        $this->assertDoesNotMatchRegularExpression('/name="docs\[tcc\]\[file\]"[^>]*required/', (string) $page->getContent());

        $expiry = ['tcc' => ['expires_on' => today()->addYear()->format('Y-m-d')], 'registration' => ['expires_on' => today()->addYear()->format('Y-m-d')], 'insurance' => ['expires_on' => today()->addYear()->format('Y-m-d')]];
        $this->post('/prequalification', $form + ['docs' => $expiry])->assertRedirect('/thanks');
        $vendor = Vendor::sole();
        $this->assertCount(3, $vendor->currentDocuments);
        $this->assertSame('valid', $vendor->complianceState());
        $this->assertSame([], Storage::disk('local')->allFiles(HeldUploads::DIR));
    }

    public function test_a_cv_survives_a_validation_error(): void
    {
        $form = ['category' => 'professional', 'first_name' => 'Devon', 'last_name' => 'Williams', 'phone' => '876-555-0142', 'email' => 'd@example.com', 'experience' => '5to10', 'consent' => '1'];
        $this->post('/careers/apply', array_merge($form, ['first_name' => '', 'cv' => $this->pdf('cv.pdf')]))->assertSessionHasErrors('first_name');
        $this->post('/careers/apply', $form)->assertRedirect('/thanks');
        $this->assertSame('cv.pdf', JobApplication::sole()->cv_name);
    }

    public function test_held_files_are_pruned_after_a_day(): void
    {
        $this->post('/careers/apply', ['category' => 'professional', 'cv' => $this->pdf('cv.pdf')]);
        $this->assertCount(1, Storage::disk('local')->allFiles(HeldUploads::DIR));

        $this->artisan('app:prune-held-uploads')->assertSuccessful();
        $this->assertCount(1, Storage::disk('local')->allFiles(HeldUploads::DIR), 'a fresh file is kept');

        touch(Storage::disk('local')->path(Storage::disk('local')->allFiles(HeldUploads::DIR)[0]), now()->subHours(25)->getTimestamp());
        $this->artisan('app:prune-held-uploads')->assertSuccessful();
        $this->assertSame([], Storage::disk('local')->allFiles(HeldUploads::DIR));
        $this->assertSame([], HeldUploads::names('application', 'cv'));
    }
}
