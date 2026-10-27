<?php

namespace Tests\Feature;

use App\Enums\JobCategory;
use App\Models\Enquiry;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Notifications\NewSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CareersAndContactTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, mixed> */
    private function application(array $overrides = []): array
    {
        return array_merge([
            'category' => 'trades', 'first_name' => 'Devon', 'last_name' => 'Williams', 'phone' => '876-555-0142',
            'experience' => '5to10', 'parish' => 'Kingston', 'consent' => '1',
        ], $overrides);
    }

    public function test_site_labour_can_apply_without_a_cv_or_email(): void
    {
        Notification::fake();
        config(['ypseaton.notify.careers' => 'hr@example.com']);
        $this->post('/careers/apply', $this->application())->assertRedirect('/thanks');
        $a = JobApplication::sole();
        $this->assertSame('JA-'.now()->format('y').'-00001', $a->reference);
        $this->assertNull($a->cv_path);
        Notification::assertSentOnDemand(NewSubmission::class, fn ($n, $c, $to) => $to->routes['mail'] === ['hr@example.com']);
    }

    public function test_professional_roles_need_a_cv_stored_privately(): void
    {
        Storage::fake('local');
        $this->post('/careers/apply', $this->application(['category' => 'professional']))->assertSessionHasErrors(['cv', 'email']);

        $this->post('/careers/apply', $this->application(['category' => 'professional', 'email' => 'e@example.com', 'cv' => UploadedFile::fake()->create('cv.pdf', 300, 'application/pdf')]))
            ->assertRedirect('/thanks');
        $a = JobApplication::sole();
        Storage::disk('local')->assertExists((string) $a->cv_path);
        $this->assertStringStartsWith('cvs/', (string) $a->cv_path);
        $this->post('/careers/apply', $this->application(['cv' => UploadedFile::fake()->create('cv.exe', 10)]))->assertSessionHasErrors('cv');
    }

    public function test_the_job_decides_the_category(): void
    {
        $job = JobPosting::factory()->create(['category' => JobCategory::Professional]);
        // Claims site labour but applies to an engineering post: the CV rule follows the job.
        $this->post('/careers/apply', $this->application(['job_posting_id' => $job->id, 'category' => 'trades']))->assertSessionHasErrors('cv');
        $closed = JobPosting::factory()->create(['closes_on' => today()->subDay()]);
        $this->post('/careers/apply', $this->application(['job_posting_id' => $closed->id]))->assertSessionHasErrors('job_posting_id');
        $this->get('/careers/apply?job='.$job->slug)->assertOk()->assertSee($job->title);
    }

    public function test_contact_form_creates_an_enquiry(): void
    {
        Notification::fake();
        $this->post('/contact', ['name' => 'Tanya Reid', 'email' => 'T@Example.com', 'topic' => 'project', 'message' => 'We need a quote for a retaining wall.'])->assertRedirect('/thanks');
        $e = Enquiry::sole();
        $this->assertSame('t@example.com', $e->email);
        $this->assertStringStartsWith('EN-', $e->reference);
        $this->post('/contact', ['name' => 'x', 'email' => 'bad', 'topic' => 'nope', 'message' => 'short'])->assertSessionHasErrors(['email', 'topic', 'message']);
    }

    public function test_forms_are_rate_limited(): void
    {
        for ($i = 0; $i < 40; $i++) {
            $this->post('/contact', []);
        }
        $this->post('/contact', [])->assertStatus(429);
    }
}
