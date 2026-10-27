<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApplicationStatus;
use App\Enums\Area;
use App\Enums\EnquiryStatus;
use App\Enums\TenderStatus;
use App\Enums\VendorStatus;
use App\Http\Controllers\Controller;
use App\Models\DocumentRoom;
use App\Models\Enquiry;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\Tender;
use App\Models\Vendor;
use App\Models\VendorDocument;
use App\Support\Notify;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Leads with the one number the signed-in role must act on: tender deadlines inside
 * DUE_SOON_DAYS (admin, estimating), certificates expiring (procurement) or applications
 * waiting for review (HR). Tiles for the role's other areas follow.
 */
class DashboardController extends Controller
{
    use Concerns;

    public function __invoke(Request $request): View
    {
        $user = $this->user($request);
        $headline = match (true) {
            $user->works(Area::Tenders) => $this->tenderHeadline(),
            $user->works(Area::Prequal) => $this->prequalHeadline(),
            default => $this->careersHeadline(),
        };

        $tiles = [];
        if ($user->works(Area::Tenders)) {
            $tiles[] = ['label' => 'Open tenders', 'value' => Tender::open()->count(), 'note' => Tender::where('status', TenderStatus::New)->count().' not yet reviewed', 'href' => route('admin.tenders.index', ['status' => 'open'])];
            $tiles[] = ['label' => 'Invitations, last 30 days', 'value' => Tender::where('created_at', '>=', now()->subDays(30))->count(),
                'previous' => Tender::whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->count(), 'period' => 'vs previous 30 days', 'href' => route('admin.tenders.index')];
            $decided = Tender::whereIn('status', [TenderStatus::Won, TenderStatus::Lost])->where('status_changed_at', '>=', now()->subYear())->pluck('status');
            $tiles[] = ['label' => 'Bids decided, last 12 months', 'value' => $decided->count(), 'note' => $decided->filter(fn ($s) => $s === TenderStatus::Won)->count().' awarded', 'href' => route('admin.tenders.index', ['status' => 'won'])];
        }
        if ($user->works(Area::Prequal)) {
            $tiles[] = ['label' => 'Prequalification to review', 'value' => Vendor::whereIn('status', [VendorStatus::New, VendorStatus::Reviewing])->count(), 'note' => 'new or under review', 'href' => route('admin.vendors.index', ['status' => 'new'])];
            $tiles[] = ['label' => 'Prequalified vendors', 'value' => Vendor::where('status', VendorStatus::Approved)->count(), 'note' => Vendor::needsRenewal()->count().' need a renewal', 'href' => route('admin.vendors.index', ['status' => 'approved'])];
        }
        if ($user->works(Area::Careers)) {
            $tiles[] = ['label' => 'Applications, last 7 days', 'value' => JobApplication::where('created_at', '>=', now()->subDays(7))->count(),
                'previous' => JobApplication::whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])->count(), 'period' => 'vs previous 7 days', 'href' => route('admin.applications.index')];
            $tiles[] = ['label' => 'Open job postings', 'value' => JobPosting::open()->count(), 'note' => 'on the careers page', 'href' => route('admin.jobs.index')];
        }
        if ($user->works(Area::Enquiries)) {
            $tiles[] = ['label' => 'New enquiries', 'value' => Enquiry::where('status', EnquiryStatus::New)->count(), 'note' => 'from the contact page', 'href' => route('admin.enquiries.index', ['status' => 'new'])];
        }
        if ($user->works(Area::Rooms)) {
            $tiles[] = ['label' => 'Client links live', 'value' => DocumentRoom::where('link_expires_at', '>', now())->count(), 'note' => 'of '.DocumentRoom::count().' document rooms', 'href' => route('admin.rooms.index')];
        }

        return view('admin.dashboard', [
            'headline' => $headline,
            'tiles' => $tiles,
            'pipeline' => $user->works(Area::Tenders) ? collect(TenderStatus::cases())->map(fn (TenderStatus $s) => ['status' => $s, 'count' => Tender::where('status', $s)->count()]) : null,
            'chart' => $user->works(Area::Tenders) ? $this->deadlineChart() : ($user->works(Area::Prequal) ? $this->expiryChart() : $this->applicationChart()),
            'notifyMissing' => $user->isAdmin() && Notify::recipients() === [],
            'notifyInvalid' => $user->isAdmin() ? Notify::invalid() : [],
        ]);
    }

    /** @return array<string, mixed> */
    private function tenderHeadline(): array
    {
        $due = Tender::dueSoon()->with('assignee')->orderBy('submission_due_at')->get();
        $passed = Tender::open()->where('submission_due_at', '<', now())->count();

        return [
            'area' => 'tenders',
            'count' => $due->count(),
            'title' => ($due->count() === 1 ? 'tender submission is' : 'tender submissions are').' due in the next '.Tender::DUE_SOON_DAYS.' days',
            'body' => $due->isEmpty()
                ? 'No open tender closes this week.'.($passed ? " {$passed} open ".str('tender')->plural($passed).' passed the deadline without a decision; close them out.' : '')
                : 'The next closes '.$due->first()->submission_due_at->format('l j F \a\t g:i a').'. Unassigned invitations are flagged below.',
            'cta' => ['label' => $due->isEmpty() ? 'Open the tender register' : 'See what is due', 'href' => route('admin.tenders.index', $due->isEmpty() ? ['status' => 'open'] : ['due' => 1])],
            'items' => $due->take(6)->map(fn (Tender $t) => [
                'href' => route('admin.tenders.show', $t), 'title' => $t->title, 'meta' => $t->entity_name.' · '.($t->assignee->name ?? 'Unassigned'),
                'chip' => $t->dueLabel(), 'tone' => $t->dueTone(), 'icon' => 'clock',
            ])->all(),
            'list' => 'Closing soonest',
            'empty' => 'Nothing closes in the next '.Tender::DUE_SOON_DAYS.' days.',
        ];
    }

    /** @return array<string, mixed> */
    private function prequalHeadline(): array
    {
        $docs = VendorDocument::with('vendor')->tracked()
            ->whereDate('expires_on', '<=', today()->addDays(Vendor::EXPIRY_WARNING_DAYS))
            ->whereHas('vendor', fn ($q) => $q->where('status', VendorStatus::Approved))->orderBy('expires_on')->get();
        $expired = $docs->filter(fn (VendorDocument $d) => $d->state() === 'expired')->count();

        return [
            'area' => 'prequal',
            'count' => $docs->count(),
            'title' => ($docs->count() === 1 ? 'certificate has' : 'certificates have').' expired or expire within '.Vendor::EXPIRY_WARNING_DAYS.' days',
            'body' => $docs->isEmpty()
                ? 'Every prequalified vendor has a current TCC, registration and insurance.'
                : "{$expired} already expired. Vendors are emailed a renewal link automatically 30 days before expiry; chase the rest by phone.",
            'cta' => ['label' => 'Vendors needing renewal', 'href' => route('admin.vendors.index', ['renewal' => 1])],
            'items' => $docs->take(6)->map(fn (VendorDocument $d) => [
                'href' => route('admin.vendors.show', $d->vendor), 'title' => $d->vendor->company_name, 'meta' => $d->kind->label(),
                'chip' => $d->state() === 'expired' ? 'Expired '.$d->expires_on?->format('j M') : $d->daysLeft().' days left', 'tone' => $d->state() === 'expired' ? 'critical' : 'attention', 'icon' => 'shield',
            ])->all(),
            'list' => 'Chase these first',
            'empty' => 'No certificates to chase.',
        ];
    }

    /** @return array<string, mixed> */
    private function careersHeadline(): array
    {
        $waiting = JobApplication::waiting()->with('jobPosting')->oldest()->get();

        return [
            'area' => 'careers',
            'count' => $waiting->count(),
            'title' => ($waiting->count() === 1 ? 'application has' : 'applications have').' waited more than '.JobApplication::REVIEW_DAYS.' days for review',
            'body' => $waiting->isEmpty() ? JobApplication::where('status', ApplicationStatus::New)->count().' new applications, all inside the window.' : 'The oldest arrived '.$waiting->first()->created_at->diffForHumans().'.',
            'cta' => ['label' => 'Review applications', 'href' => route('admin.applications.index', $waiting->isEmpty() ? ['status' => 'new'] : ['waiting' => 1])],
            'items' => $waiting->take(6)->map(fn (JobApplication $a) => [
                'href' => route('admin.applications.show', $a), 'title' => $a->full_name, 'meta' => $a->position(),
                'chip' => $a->created_at->diffForHumans(['syntax' => CarbonInterface::DIFF_ABSOLUTE, 'short' => true]), 'tone' => 'attention', 'icon' => 'clock',
            ])->all(),
            'list' => 'Waiting longest',
            'empty' => 'Nobody is waiting.',
        ];
    }

    /** @return array{title: string, note: string, bars: list<array{label: string, value: int, hint: string}>} */
    private function deadlineChart(): array
    {
        $start = today()->startOfWeek();
        $dates = Tender::open()->whereBetween('submission_due_at', [$start, $start->copy()->addWeeks(8)])->pluck('submission_due_at');
        $bars = [];
        for ($i = 0; $i < 8; $i++) {
            $from = $start->copy()->addWeeks($i);
            $to = $from->copy()->addWeek();
            $bars[] = ['label' => $i === 0 ? 'This wk' : $from->format('j M'), 'value' => $dates->filter(fn ($d) => $d >= $from && $d < $to)->count(), 'hint' => 'Week of '.$from->format('j M')];
        }

        return ['title' => 'Open tender deadlines by week', 'note' => 'next 8 weeks', 'bars' => $bars];
    }

    /** @return array{title: string, note: string, bars: list<array{label: string, value: int, hint: string}>} */
    private function expiryChart(): array
    {
        $start = today()->startOfMonth();
        $dates = VendorDocument::tracked()->whereBetween('expires_on', [$start, $start->copy()->addMonths(12)])
            ->whereHas('vendor', fn ($q) => $q->where('status', VendorStatus::Approved))->pluck('expires_on');
        $bars = [];
        for ($i = 0; $i < 12; $i++) {
            $m = $start->copy()->addMonths($i);
            $bars[] = ['label' => $m->format('M'), 'value' => $dates->filter(fn ($d) => $d->isSameMonth($m))->count(), 'hint' => $m->format('F Y')];
        }

        return ['title' => 'Certificate expiries by month', 'note' => 'approved vendors, next 12 months', 'bars' => $bars];
    }

    /** @return array{title: string, note: string, bars: list<array{label: string, value: int, hint: string}>} */
    private function applicationChart(): array
    {
        $start = today()->startOfWeek()->subWeeks(7);
        $dates = JobApplication::where('created_at', '>=', $start)->pluck('created_at');
        $bars = [];
        for ($i = 0; $i < 8; $i++) {
            $from = $start->copy()->addWeeks($i);
            $to = $from->copy()->addWeek();
            $bars[] = ['label' => $i === 7 ? 'This wk' : $from->format('j M'), 'value' => $dates->filter(fn ($d) => $d >= $from && $d < $to)->count(), 'hint' => 'Week of '.$from->format('j M')];
        }

        return ['title' => 'Applications by week', 'note' => 'last 8 weeks', 'bars' => $bars];
    }
}
