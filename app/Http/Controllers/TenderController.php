<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTenderRequest;
use App\Models\Tender;
use App\Support\Intake;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

/** "Invite us to tender": procuring entities send an ITB/RFQ straight to estimating. */
class TenderController extends Controller
{
    public function create(): View
    {
        return view('pages.tender');
    }

    public function store(StoreTenderRequest $request): RedirectResponse
    {
        if (Intake::isBot($request, Tender::fakeReference(), 'Tender invitation')) {
            $request->releaseHeldUploads();

            return to_route('thanks');
        }

        $data = $request->safe()->except(['due_date', 'due_time', 'site_visit_date', 'site_visit_time', 'files']);
        $tender = Tender::create($data + [
            'submission_due_at' => $request->dueAt(),
            'site_visit_at' => $request->siteVisitAt(),
            'source_url' => Intake::source($request),
        ]);

        /** @var list<UploadedFile> $files */
        $files = $request->file('files', []);
        foreach ($files as $file) {
            $tender->files()->create([
                // Random name on the private disk, one folder per tender.
                'path' => $file->store('tenders/'.$tender->id, 'local'),
                'original_name' => mb_substr($file->getClientOriginalName(), 0, 200),
                'mime' => $file->getMimeType(),
                'size' => (int) $file->getSize(),
            ]);
        }

        $request->releaseHeldUploads();
        Intake::complete($tender->refresh(), $request);

        return to_route('thanks');
    }
}
