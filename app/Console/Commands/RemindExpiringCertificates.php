<?php

namespace App\Console\Commands;

use App\Enums\VendorStatus;
use App\Models\Vendor;
use App\Models\VendorDocument;
use App\Notifications\CertificateExpiring;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

/**
 * Daily: emails each prequalified vendor whose TCC, registration or insurance expires within
 * Vendor::EXPIRY_WARNING_DAYS a signed link to upload the renewal. One reminder per certificate.
 */
class RemindExpiringCertificates extends Command
{
    protected $signature = 'app:remind-expiring {--dry-run : List who would be emailed without sending}';

    protected $description = 'Email prequalified vendors a renewal link before a certificate expires';

    public function handle(): int
    {
        $docs = VendorDocument::with('vendor')->whereNull('superseded_at')->whereNull('reminded_at')->whereNotNull('expires_on')
            ->whereDate('expires_on', '<=', today()->addDays(Vendor::EXPIRY_WARNING_DAYS))
            ->whereHas('vendor', fn ($q) => $q->where('status', VendorStatus::Approved))->get();

        foreach ($docs->groupBy('vendor_id') as $group) {
            /** @var VendorDocument $first */
            $first = $group->first();
            $vendor = $first->vendor;
            $this->line("{$vendor->reference} {$vendor->company_name}: ".$group->map(fn (VendorDocument $d) => $d->kind->short())->implode(', '));
            if ($this->option('dry-run')) {
                continue;
            }
            $url = URL::temporarySignedRoute('prequal.renew', now()->addDays(30), ['vendor' => $vendor]);
            // Sent straight away: a console run has no response to defer behind.
            Notification::route('mail', [$vendor->email])->notify(new CertificateExpiring($group->values(), $url));
            VendorDocument::whereIn('id', $group->pluck('id'))->update(['reminded_at' => now()]);
            $vendor->log('Renewal reminder emailed for '.$group->map(fn (VendorDocument $d) => $d->kind->short())->implode(', ').'.');
        }
        $this->info($docs->count().' certificate(s) to renew.');

        return self::SUCCESS;
    }
}
