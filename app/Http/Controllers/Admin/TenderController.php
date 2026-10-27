<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Area;
use App\Enums\TenderStatus;
use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Models\TenderFile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/** The tender register: invitations by deadline, bid/no-bid, pricing, submission and award. */
class TenderController extends Controller
{
    use Concerns;

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Tender::class);
        $filters = $this->filters($request);
        $counts = Tender::query()->filter(array_merge($filters, ['status' => null]))
            ->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        // Open tenders by nearest deadline first; closed ones newest first underneath.
        $tenders = Tender::with('assignee')->withCount('files')->filter($filters)
            ->orderByRaw("case when status in ('new', 'reviewing', 'pricing') then 0 else 1 end")
            ->orderByRaw("case when status in ('new', 'reviewing', 'pricing') then submission_due_at end asc")
            ->orderByDesc('submission_due_at')
            ->paginate(25)->withQueryString();

        return view('admin.tenders.index', [
            'tenders' => $tenders,
            'filters' => $filters,
            'counts' => $counts,
            'openCount' => Tender::open()->count(),
            'staff' => User::working(Area::Tenders)->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function show(Tender $tender): View
    {
        Gate::authorize('view', $tender);

        return view('admin.tenders.show', [
            'tender' => $tender->load(['assignee', 'files', 'notes.user']),
            'staff' => User::working(Area::Tenders)->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Tender $tender): RedirectResponse
    {
        Gate::authorize('update', $tender);
        $user = $this->user($request);
        $data = $request->validate([
            'status' => ['sometimes', Rule::enum(TenderStatus::class)],
            'assigned_to' => ['sometimes', 'nullable', 'integer', Rule::exists('users', 'id')->where('active', true)],
        ]);

        // Check the assignee before changing anything, so a refused assignment leaves no half-saved status.
        $assignTo = isset($data['assigned_to']) ? (int) $data['assigned_to'] : null;
        $reassign = array_key_exists('assigned_to', $data) && $tender->assigned_to !== $assignTo;
        $assignee = $reassign && $assignTo ? User::find($assignTo) : null;
        if ($assignee && ! $assignee->works(Area::Tenders)) {
            return back()->withErrors(['assigned_to' => "{$assignee->name} works in {$assignee->role->label()} and can't see tenders."]);
        }

        if (isset($data['status']) && $tender->claimStatus($status = TenderStatus::from($data['status']))) {
            $tender->log('Status changed to '.$status->label().'.', 'status', $user);
        }
        if ($reassign) {
            $tender->assigned_to = $assignee?->id;
            $tender->log($assignee ? "Assigned to {$assignee->name}." : 'Unassigned.', 'assign', $user);
        }
        $tender->save();

        return back()->with('status', "{$tender->reference} saved.");
    }

    public function note(Request $request, Tender $tender): RedirectResponse
    {
        Gate::authorize('update', $tender);
        $data = $request->validate(['body' => ['required', 'string', 'max:3000']]);
        $tender->log($data['body'], 'note', $this->user($request));

        return back()->with('status', 'Note added.')->withFragment('timeline');
    }

    public function file(Request $request, Tender $tender, TenderFile $file): StreamedResponse
    {
        Gate::authorize('openFile', [$tender, $file]);
        abort_unless(Storage::disk('local')->exists($file->path), 404);
        $tender->log("Opened {$file->original_name}.", 'file', $this->user($request));
        $name = Str::slug($tender->reference.'-'.pathinfo($file->original_name, PATHINFO_FILENAME)).'.'.pathinfo($file->path, PATHINFO_EXTENSION);

        return Storage::disk('local')->download($file->path, $name, ['Cache-Control' => 'private, no-store']);
    }

    public function export(Request $request): StreamedResponse
    {
        Gate::authorize('viewAny', Tender::class);
        $query = Tender::with('assignee')->filter($this->filters($request))->orderBy('submission_due_at');

        return $this->csv('yps-tenders', ['Reference', 'Received', 'Status', 'Procuring entity', 'Sector', 'Tender', 'Their reference', 'Method', 'Parish', 'Deadline', 'Estimator', 'Contact', 'Email', 'Phone'],
            $query->lazyById(500)->map(fn (Tender $t) => [
                $t->reference, $t->created_at->format('Y-m-d'), $t->status->label(), $t->entity_name, $t->sector, $t->title, $t->their_reference,
                $t->method->short(), $t->parish, $t->submission_due_at->format('Y-m-d H:i'), $t->assignee->name ?? '', $t->contact_name, $t->email, format_phone($t->phone),
            ]));
    }

    /** @return array<string, string|null> */
    private function filters(Request $request): array
    {
        $status = input_string($request->query('status'));
        $assigned = input_string($request->query('assigned'));
        $sector = input_string($request->query('sector'));

        return [
            'status' => $status === 'open' ? 'open' : TenderStatus::tryFrom($status)?->value,
            'sector' => array_key_exists($sector, Tender::SECTORS) ? $sector : null,
            'assigned' => match (true) {
                $assigned === 'me' => (string) $request->user()?->getAuthIdentifier(),
                $assigned === 'none', ctype_digit($assigned) => $assigned,
                default => null,
            },
            'due' => $request->boolean('due') ? '1' : null,
            'q' => input_string($request->query('q')) ?: null,
        ];
    }
}
