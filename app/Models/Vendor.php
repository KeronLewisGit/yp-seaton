<?php

namespace App\Models;

use App\Contracts\Submission;
use App\Enums\Area;
use App\Enums\DocumentKind;
use App\Enums\VendorStatus;
use App\Enums\VendorType;
use App\Models\Concerns\HasReference;
use App\Models\Concerns\HasTimeline;
use Database\Factories\VendorFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * A subcontractor or supplier applying for (or holding) prequalification.
 *
 * @property int $id
 * @property string $reference
 * @property VendorStatus $status
 * @property VendorType $type
 * @property string $company_name
 * @property string|null $trading_as
 * @property string $trn
 * @property string|null $company_number
 * @property int|null $year_established
 * @property string $address
 * @property string $parish
 * @property string $contact_name
 * @property string|null $contact_role
 * @property string $email
 * @property string $phone
 * @property list<string> $trades
 * @property list<string>|null $parishes_served
 * @property string|null $employees
 * @property string|null $registration_grade
 * @property string|null $experience
 * @property string|null $message
 * @property int|null $reviewed_by
 * @property Carbon|null $approved_at
 * @property Carbon|null $consented_at
 * @property Carbon|null $status_changed_at
 * @property Carbon $created_at
 * @property-read User|null $reviewer
 * @property-read Collection<int, VendorDocument> $documents
 * @property-read Collection<int, VendorDocument> $currentDocuments
 */
class Vendor extends Model implements Submission
{
    /** @use HasFactory<VendorFactory> */
    use HasFactory, HasReference, HasTimeline;

    /** Certificates expiring within this many days are flagged (and the vendor is reminded). */
    public const int EXPIRY_WARNING_DAYS = 30;

    public const array FILE_TYPES = ['pdf', 'jpg', 'jpeg', 'png'];

    public const array EMPLOYEE_BANDS = ['1-5' => '1 to 5', '6-20' => '6 to 20', '21-50' => '21 to 50', '51-200' => '51 to 200', '200+' => 'Over 200'];

    protected $fillable = [
        'status', 'type', 'company_name', 'trading_as', 'trn', 'company_number', 'year_established', 'address', 'parish',
        'contact_name', 'contact_role', 'email', 'phone', 'trades', 'parishes_served', 'employees', 'registration_grade',
        'experience', 'message', 'reviewed_by', 'approved_at', 'consented_at', 'status_changed_at', 'source_url',
    ];

    public static function referencePrefix(): string
    {
        return 'PQ';
    }

    #[\Override]
    protected function casts(): array
    {
        return [
            'status' => VendorStatus::class,
            'type' => VendorType::class,
            'trades' => 'array',
            'parishes_served' => 'array',
            'approved_at' => 'datetime',
            'consented_at' => 'datetime',
            'status_changed_at' => 'datetime',
        ];
    }

    #[\Override]
    protected static function booted(): void
    {
        static::creating(function (self $vendor): void {
            $vendor->status ??= VendorStatus::New;
        });
        static::saving(function (self $vendor): void {
            $vendor->setAttribute('phone_digits', preg_replace('/\D+/', '', $vendor->phone) ?: null);
        });
    }

    /** @return HasMany<VendorDocument, $this> */
    public function documents(): HasMany
    {
        return $this->hasMany(VendorDocument::class)->orderByDesc('id');
    }

    /** @return HasMany<VendorDocument, $this> */
    public function currentDocuments(): HasMany
    {
        return $this->hasMany(VendorDocument::class)->whereNull('superseded_at')->orderBy('kind');
    }

    /** @return BelongsTo<User, $this> */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function current(DocumentKind $kind): ?VendorDocument
    {
        return $this->currentDocuments->first(fn (VendorDocument $d) => $d->kind === $kind);
    }

    /**
     * The state of every required certificate.
     *
     * @return list<array{kind: DocumentKind, document: VendorDocument|null, state: string}>
     */
    public function compliance(): array
    {
        return array_map(function (DocumentKind $kind) {
            $doc = $this->current($kind);

            return ['kind' => $kind, 'document' => $doc, 'state' => $doc ? $doc->state() : 'missing'];
        }, $this->type->requiredDocuments());
    }

    /** Worst state across required certificates: missing > expired > expiring > valid. */
    public function complianceState(): string
    {
        $states = array_column($this->compliance(), 'state');
        foreach (['missing', 'expired', 'expiring'] as $s) {
            if (in_array($s, $states, true)) {
                return $s;
            }
        }

        return 'valid';
    }

    public function nextExpiry(): ?Carbon
    {
        return $this->currentDocuments->filter(fn (VendorDocument $d) => $d->expires_on !== null)->min('expires_on');
    }

    public function moveTo(VendorStatus $status): bool
    {
        if ($this->status === $status) {
            return false;
        }
        $this->status = $status;
        $this->status_changed_at = now();
        $this->approved_at = $status === VendorStatus::Approved ? now() : $this->approved_at;

        return true;
    }

    /**
     * Approved vendors with a current certificate expired or expiring within EXPIRY_WARNING_DAYS.
     *
     * @param  Builder<self>  $query
     */
    public function scopeNeedsRenewal(Builder $query): void
    {
        $query->where('status', VendorStatus::Approved)->whereHas('documents', fn (Builder $d) => $d->whereNull('superseded_at')
            ->whereNotNull('expires_on')->whereDate('expires_on', '<=', today()->addDays(self::EXPIRY_WARNING_DAYS)));
    }

    /**
     * @param  Builder<self>  $query
     * @param  array<string, mixed>  $f
     */
    public function scopeFilter(Builder $query, array $f): void
    {
        $query
            ->when($f['status'] ?? null, fn (Builder $q, $v) => $q->where('status', $v))
            ->when($f['type'] ?? null, fn (Builder $q, $v) => $q->where('type', $v))
            ->when($f['trade'] ?? null, fn (Builder $q, $v) => $q->where('trades', 'like', '%"'.str_replace(['%', '_', '"'], '', (string) $v).'"%'))
            ->when($f['renewal'] ?? null, fn (Builder $q) => $q->needsRenewal())
            ->when($f['q'] ?? null, function (Builder $q, $term) {
                $like = '%'.str_replace(['%', '_'], ['\%', '\_'], (string) $term).'%';
                $digits = preg_replace('/\D+/', '', (string) $term);
                $q->where(function (Builder $w) use ($like, $digits) {
                    $w->where('company_name', 'like', $like)->orWhere('trading_as', 'like', $like)->orWhere('reference', 'like', $like)
                        ->orWhere('contact_name', 'like', $like)->orWhere('email', 'like', $like);
                    if (strlen((string) $digits) >= 3) {
                        $w->orWhere('trn', 'like', '%'.$digits.'%')->orWhere('phone_digits', 'like', '%'.$digits.'%');
                    }
                });
            });
    }

    public function displayName(): string
    {
        return $this->company_name.($this->trading_as ? ' t/a '.$this->trading_as : '');
    }

    public function referenceNumber(): string
    {
        return $this->reference;
    }

    public function kindLabel(): string
    {
        return 'Prequalification';
    }

    public function area(): Area
    {
        return Area::Prequal;
    }

    public function senderName(): string
    {
        return $this->contact_name;
    }

    public function senderEmail(): ?string
    {
        return $this->email;
    }

    public function summary(): array
    {
        return [
            'Company' => $this->displayName(),
            'Type' => $this->type->label(),
            'TRN' => format_trn($this->trn),
            'Trades' => implode(', ', array_map(fn (string $t) => (string) (yps('trades.'.$t) ?? $t), $this->trades)),
            'Contact' => $this->contact_name.' · '.format_phone($this->phone).' · '.$this->email,
        ];
    }

    public function adminUrl(): string
    {
        return route('admin.vendors.show', $this);
    }

    public function nextSteps(): string
    {
        return 'Our procurement team checks your certificates and will email you when your company is prequalified. We will remind you before a certificate expires, with a link to upload the renewal.';
    }
}
