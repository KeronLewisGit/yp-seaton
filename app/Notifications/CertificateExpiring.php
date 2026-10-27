<?php

namespace App\Notifications;

use App\Models\VendorDocument;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

/** To a prequalified vendor: these certificates expire soon, upload the renewals with this link. */
class CertificateExpiring extends Notification
{
    /** @param Collection<int, VendorDocument> $documents */
    public function __construct(public Collection $documents, public string $renewUrl) {}

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $vendor = $this->documents->first()?->vendor;
        $mail = (new MailMessage)
            ->subject('Certificate renewal for your Y.P. Seaton prequalification'.($vendor ? ' ('.$vendor->reference.')' : ''))
            ->greeting('Hello'.($vendor ? ' '.$vendor->contact_name : '').',')
            ->line('To stay prequalified as a subcontractor or supplier, please send us the renewed copy of:');
        foreach ($this->documents as $d) {
            $mail->line('- '.$d->kind->label().': '.($d->state() === 'expired' ? 'expired on ' : 'expires on ').$d->expires_on?->format('j F Y'));
        }

        return $mail->action('Upload the renewal', $this->renewUrl)
            ->line('The link works for 30 days and needs no password.');
    }
}
