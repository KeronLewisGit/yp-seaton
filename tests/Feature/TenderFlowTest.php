<?php

namespace Tests\Feature;

use App\Enums\TenderStatus;
use App\Models\Tender;
use App\Notifications\NewSubmission;
use App\Notifications\SubmissionReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TenderFlowTest extends TestCase
{
    use RefreshDatabase;

    /** @return array<string, mixed> */
    private function tender(array $overrides = []): array
    {
        return array_merge([
            'sector' => 'public',
            'entity_name' => 'Sample Water Authority',
            'contact_name' => 'Andre Campbell',
            'email' => 'Procurement@Example.org',
            'phone' => '(876) 555-0101',
            'title' => 'Rehabilitation of a sewage lift station',
            'their_reference' => 'NCB-2026-014',
            'method' => 'open',
            'parish' => 'St. Catherine',
            'scope' => 'Civil works for a lift station and force main.',
            'due_date' => today()->addDays(12)->format('Y-m-d'),
            'due_time' => '14:00',
        ], $overrides);
    }

    public function test_a_procuring_entity_can_invite_a_tender_with_documents(): void
    {
        Storage::fake('local');
        Notification::fake();
        config(['ypseaton.notify.default' => 'office@example.com', 'ypseaton.notify.tenders' => 'estimating@example.com']);

        $res = $this->post('/tenders', $this->tender([
            'files' => [UploadedFile::fake()->create('itb.pdf', 300, 'application/pdf'), UploadedFile::fake()->create('boq.xlsx', 50)],
            'bid_security' => '1',
        ]));

        $res->assertRedirect('/thanks');
        $tender = Tender::sole();
        $this->assertSame(sprintf('TI-%s-%05d', now()->format('y'), $tender->id), $tender->reference);
        $this->assertSame(TenderStatus::New, $tender->status);
        $this->assertSame('procurement@example.org', $tender->email);
        $this->assertTrue($tender->bid_security);
        $this->assertSame('14:00', $tender->submission_due_at->format('H:i'));
        $this->assertCount(2, $tender->files);
        foreach ($tender->files as $f) {
            Storage::disk('local')->assertExists($f->path);
            $this->assertStringStartsWith('tenders/'.$tender->id.'/', $f->path);
            $this->assertFileDoesNotExist(public_path($f->path));
        }
        $this->assertSame('Received from the website.', $tender->notes()->first()?->body);

        Notification::assertSentOnDemand(NewSubmission::class, fn ($n, $ch, $notifiable) => $notifiable->routes['mail'] === ['estimating@example.com']);
        Notification::assertSentOnDemand(SubmissionReceived::class, fn ($n, $ch, $notifiable) => $notifiable->routes['mail'] === ['procurement@example.org']);

        $this->get('/thanks')->assertOk()->assertSee($tender->reference);
    }

    public function test_area_inbox_falls_back_to_the_default(): void
    {
        Notification::fake();
        config(['ypseaton.notify.default' => 'office@example.com', 'ypseaton.notify.tenders' => '']);
        $this->post('/tenders', $this->tender())->assertRedirect('/thanks');
        Notification::assertSentOnDemand(NewSubmission::class, fn ($n, $ch, $notifiable) => $notifiable->routes['mail'] === ['office@example.com']);
    }

    public function test_a_deadline_in_the_past_is_refused(): void
    {
        $this->from('/tenders')->post('/tenders', $this->tender(['due_date' => today()->format('Y-m-d'), 'due_time' => '00:01']))
            ->assertRedirect('/tenders')->assertSessionHasErrors('due_time');
        $this->post('/tenders', $this->tender(['due_date' => today()->subDay()->format('Y-m-d')]))->assertSessionHasErrors('due_date');
        $this->assertSame(0, Tender::count());
    }

    public function test_required_fields_and_file_rules(): void
    {
        $this->post('/tenders', [])->assertSessionHasErrors(['sector', 'entity_name', 'contact_name', 'email', 'phone', 'title', 'method', 'scope', 'due_date', 'due_time']);
        $this->post('/tenders', $this->tender(['files' => [UploadedFile::fake()->create('run.exe', 10)]]))->assertSessionHasErrors('files.0');
        $this->post('/tenders', $this->tender(['files' => array_fill(0, 6, UploadedFile::fake()->create('a.pdf', 10, 'application/pdf'))]))->assertSessionHasErrors('files');
        $this->post('/tenders', $this->tender(['clarification_due_on' => today()->addDays(30)->format('Y-m-d')]))->assertSessionHasErrors('clarification_due_on');
        $this->post('/tenders', $this->tender(['method' => 'bribe']))->assertSessionHasErrors('method');
    }

    public function test_bots_get_a_thank_you_and_nothing_is_stored(): void
    {
        Notification::fake();
        $this->post('/tenders', $this->tender(['website' => 'spam']))->assertRedirect('/thanks');
        $this->assertSame(0, Tender::count());
        Notification::assertNothingSent();
        $this->get('/thanks')->assertSee('TI-'.now()->format('y').'-00000');
    }

    public function test_thanks_without_a_submission_goes_home(): void
    {
        $this->get('/thanks')->assertRedirect('/');
    }

    public function test_due_soon_scope_and_labels(): void
    {
        $soon = Tender::factory()->dueIn(3)->create();
        Tender::factory()->dueIn(20)->create();
        Tender::factory()->dueIn(2)->create(['status' => TenderStatus::Submitted]);
        $past = Tender::factory()->create(['submission_due_at' => now()->subDay()]);

        $this->assertSame([$soon->id], Tender::dueSoon()->pluck('id')->all());
        $this->assertSame('3 days left', $soon->dueLabel());
        $this->assertSame('critical', $past->dueTone());
        $this->assertSame('Deadline passed', $past->dueLabel());
    }

    public function test_junk_array_input_redisplays_the_form_instead_of_crashing(): void
    {
        $junk = $this->tender(['sector' => ['public'], 'entity_name' => ['x'], 'method' => ['open'], 'parish' => ['Kingston'], 'due_date' => ['x'], 'bid_security' => ['1']]);
        $this->from('/tenders')->post('/tenders', $junk)->assertRedirect('/tenders')->assertSessionHasErrors(['sector', 'entity_name', 'method', 'due_date']);
        // Following the redirect re-renders the form with the junk as old input.
        $this->followingRedirects()->from('/tenders')->post('/tenders', $junk)->assertOk()->assertSee('Please check');
        $this->assertSame(0, Tender::count());
    }
}
