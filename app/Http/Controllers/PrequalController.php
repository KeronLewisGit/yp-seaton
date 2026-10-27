<?php

namespace App\Http\Controllers;

use App\Enums\DocumentKind;
use App\Enums\VendorStatus;
use App\Http\Requests\StoreVendorRequest;
use App\Models\Vendor;
use App\Models\VendorDocument;
use App\Notifications\NewSubmission;
use App\Support\Intake;
use App\Support\Notify;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

/** Subcontractor and supplier prequalification, and the signed renewal link sent before a certificate expires. */
class PrequalController extends Controller
{
    public function create(): View
    {
        return view('pages.prequal');
    }

    public function store(StoreVendorRequest $request): RedirectResponse
    {
        if (Intake::isBot($request, Vendor::fakeReference(), 'Prequalification')) {
            return to_route('thanks');
        }

        $vendor = Vendor::create($request->safe()->except(['docs', 'consent']) + [
            'consented_at' => now(),
            'source_url' => Intake::source($request),
        ]);
        foreach (DocumentKind::cases() as $kind) {
            $this->storeDocument($vendor, $kind, $request);
        }

        Intake::complete($vendor->refresh(), $request);

        return to_route('thanks');
    }

    /** The renewal page, reached only through the signed link in a CertificateExpiring email. */
    public function renew(Request $request, Vendor $vendor): View
    {
        $this->guardRenewal($request, $vendor);
        // The form posts to a link signed for the same time as the one in the email.
        $action = URL::temporarySignedRoute('prequal.renew.store', Carbon::createFromTimestamp((int) $request->query('expires')), ['vendor' => $vendor, 'for' => input_string($request->query('for'))]);

        return view('pages.prequal-renew', ['vendor' => $vendor->load('currentDocuments'), 'action' => $action]);
    }

    public function storeRenewal(Request $request, Vendor $vendor): RedirectResponse
    {
        $this->guardRenewal($request, $vendor);
        $request->validate([
            'docs' => ['required', 'array'],
            'docs.*' => ['array'],
            'docs.*.file' => ['nullable', 'file', 'max:5120', 'mimes:'.implode(',', Vendor::FILE_TYPES)],
            'docs.*.number' => ['nullable', 'string', 'max:80'],
            'docs.*.expires_on' => ['nullable', 'required_with:docs.*.file', 'date_format:Y-m-d', 'after:today'],
        ], [
            'docs.*.expires_on.after' => 'That certificate has already expired. Upload the renewed one.',
            'docs.*.expires_on.required_with' => 'Enter the expiry date of each certificate you upload.',
            'docs.*.file.max' => 'Each file must be 5 MB or smaller.',
            'docs.*.file.mimes' => 'Certificates must be PDF, JPG or PNG files.',
        ]);
        $stored = 0;
        foreach (DocumentKind::certificates() as $kind) {
            if ($this->storeDocument($vendor, $kind, $request, supersede: true)) {
                $stored++;
            }
        }
        if ($stored === 0) {
            return back()->withErrors(['docs' => 'Choose at least one renewed certificate to upload.']);
        }

        $vendor->log("Vendor uploaded {$stored} renewed ".str('certificate')->plural($stored).' through the renewal link.');
        Notify::office(new NewSubmission($vendor), $vendor->area());
        Intake::remember($request, $vendor->reference, 'Certificate renewal');

        return to_route('thanks');
    }

    /**
     * A renewal link works only for a vendor still on the books, and only until the certificates
     * it was sent for have been renewed: once used, the same email cannot replace them again.
     */
    private function guardRenewal(Request $request, Vendor $vendor): void
    {
        abort_if($vendor->status === VendorStatus::Declined, 403, 'This renewal link is no longer active. Please contact our procurement team.');
        abort_if($vendor->awaitingRenewal(input_string($request->query('for')))->isEmpty(), 403, 'This renewal link has already been used. If you need to send another certificate, contact our procurement team for a new link.');
    }

    private function storeDocument(Vendor $vendor, DocumentKind $kind, Request $request, bool $supersede = false): ?VendorDocument
    {
        $file = $request->file('docs.'.$kind->value.'.file');
        if (! $file instanceof UploadedFile) {
            return null;
        }
        if ($supersede) {
            $vendor->documents()->where('kind', $kind)->whereNull('superseded_at')->update(['superseded_at' => now()]);
        }

        return $vendor->documents()->create([
            'kind' => $kind,
            'path' => $file->store('vendors/'.$vendor->id, 'local'),
            'original_name' => mb_substr($file->getClientOriginalName(), 0, 200),
            'mime' => $file->getMimeType(),
            'size' => (int) $file->getSize(),
            'number' => input_string($request->input('docs.'.$kind->value.'.number')) ?: null,
            // Only certificates expire; a date sent with a supporting document is ignored.
            'expires_on' => $kind->expires() ? (input_string($request->input('docs.'.$kind->value.'.expires_on')) ?: null) : null,
        ]);
    }
}
