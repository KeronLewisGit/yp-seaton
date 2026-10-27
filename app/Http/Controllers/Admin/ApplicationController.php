<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ApplicationStatus;
use App\Enums\JobCategory;
use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationController extends Controller
{
    use Concerns;

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', JobApplication::class);
        $filters = $this->filters($request);
        $counts = JobApplication::query()->filter(array_merge($filters, ['status' => null]))
            ->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status');

        return view('admin.applications.index', [
            'applications' => JobApplication::with('jobPosting')->filter($filters)
                ->orderByRaw("case when status = 'new' then 0 else 1 end")->orderByDesc('id')->paginate(25)->withQueryString(),
            'filters' => $filters,
            'counts' => $counts,
            'jobs' => JobPosting::orderBy('title')->get(['id', 'title']),
        ]);
    }

    public function show(JobApplication $application): View
    {
        Gate::authorize('view', $application);

        return view('admin.applications.show', ['application' => $application->load(['jobPosting', 'notes.user'])]);
    }

    public function update(Request $request, JobApplication $application): RedirectResponse
    {
        Gate::authorize('update', $application);
        $data = $request->validate(['status' => ['required', Rule::enum(ApplicationStatus::class)]]);
        if ($application->moveTo($status = ApplicationStatus::from($data['status']))) {
            $application->save();
            $application->log('Status changed to '.$status->label().'.', 'status', $this->user($request));
        }

        return back()->with('status', "{$application->reference} saved.");
    }

    public function note(Request $request, JobApplication $application): RedirectResponse
    {
        Gate::authorize('update', $application);
        $data = $request->validate(['body' => ['required', 'string', 'max:3000']]);
        $application->log($data['body'], 'note', $this->user($request));

        return back()->with('status', 'Note added.')->withFragment('timeline');
    }

    public function cv(Request $request, JobApplication $application): StreamedResponse
    {
        Gate::authorize('openCv', $application);
        abort_unless($application->cv_path && Storage::disk('local')->exists($application->cv_path), 404);
        $application->log('Opened the CV.', 'file', $this->user($request));
        $name = Str::slug($application->reference.'-'.$application->full_name.'-cv').'.'.pathinfo($application->cv_path, PATHINFO_EXTENSION);

        return Storage::disk('local')->download($application->cv_path, $name, ['Cache-Control' => 'private, no-store']);
    }

    public function export(Request $request): StreamedResponse
    {
        Gate::authorize('viewAny', JobApplication::class);
        $query = JobApplication::with('jobPosting')->filter($this->filters($request));

        return $this->csv('yps-applications', ['Reference', 'Received', 'Status', 'Name', 'Position', 'Type of work', 'Experience', 'Parish', 'Phone', 'Email', 'Available from', 'CV'],
            $query->lazyByIdDesc(500)->map(fn (JobApplication $a) => [
                $a->reference, $a->created_at->format('Y-m-d'), $a->status->label(), $a->full_name, $a->position(), $a->category->label(), $a->experience->label(),
                $a->parish, format_phone($a->phone), $a->email, $a->available_from?->format('Y-m-d'), $a->cv_path ? 'yes' : 'no',
            ]));
    }

    /** @return array<string, string|null> */
    private function filters(Request $request): array
    {
        $job = input_string($request->query('job'));

        return [
            'status' => ApplicationStatus::tryFrom(input_string($request->query('status')))?->value,
            'category' => JobCategory::tryFrom(input_string($request->query('category')))?->value,
            'job' => ctype_digit($job) ? $job : null,
            'waiting' => $request->boolean('waiting') ? '1' : null,
            'q' => input_string($request->query('q')) ?: null,
        ];
    }
}
