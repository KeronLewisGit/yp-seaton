<?php

namespace App\Models;

use App\Contracts\Submission;
use App\Enums\Area;
use App\Enums\ProcurementMethod;
use App\Enums\TenderStatus;
use App\Models\Concerns\HasReference;
use App\Models\Concerns\HasTimeline;
use Database\Factories\TenderFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * An invitation to tender or request for quotation from a procuring entity.
 *
 * @property int $id
 * @property string $reference
 * @property TenderStatus $status
 * @property string $sector
 * @property string $entity_name
 * @property string $contact_name
 * @property string|null $contact_role
 * @property string $email
 * @property string $phone
 * @property string $title
 * @property string|null $their_reference
 * @property ProcurementMethod $method
 * @property string|null $parish
 * @property string|null $location
 * @property string $scope
 * @property string|null $estimated_value
 * @property Carbon $submission_due_at
 * @property Carbon|null $clarification_due_on
 * @property Carbon|null $site_visit_at
 * @property bool $bid_security
 * @property string|null $documents_url
 * @property string|null $message
 * @property int|null $assigned_to
 * @property Carbon|null $submitted_at
 * @property Carbon|null $status_changed_at
 * @property string|null $source_url
 * @property Carbon $created_at
 * @property-read User|null $assignee
 * @property-read Collection<int, TenderFile> $files
 */
class Tender extends Model implements Submission
{
    /** @use HasFactory<TenderFactory> */
    use HasFactory, HasReference, HasTimeline;

    /** The dashboard counts open tenders due within this many days. */
    public const int DUE_SOON_DAYS = 7;

    public const array SECTORS = ['public' => 'Government ministry, agency or public body', 'private' => 'Private-sector client or developer'];

    /** Tender documents: what procuring entities usually send. */
    public const array FILE_TYPES = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip'];

    public const int MAX_FILES = 5;

    protected $fillable = [
        'status', 'sector', 'entity_name', 'contact_name', 'contact_role', 'email', 'phone', 'title', 'their_reference',
        'method', 'parish', 'location', 'scope', 'estimated_value', 'submission_due_at', 'clarification_due_on',
        'site_visit_at', 'bid_security', 'documents_url', 'message', 'assigned_to', 'submitted_at', 'status_changed_at', 'source_url',
    ];

    public static function referencePrefix(): string
    {
        return 'TI';
    }

    #[\Override]
    protected function casts(): array
    {
        return [
            'status' => TenderStatus::class,
            'method' => ProcurementMethod::class,
            'submission_due_at' => 'datetime',
            'clarification_due_on' => 'date',
            'site_visit_at' => 'datetime',
            'bid_security' => 'boolean',
            'submitted_at' => 'datetime',
            'status_changed_at' => 'datetime',
        ];
    }

    #[\Override]
    protected static function booted(): void
    {
        static::creating(function (self $tender): void {
            $tender->status ??= TenderStatus::New;
        });
        static::saving(function (self $tender): void {
            $tender->setAttribute('phone_digits', preg_replace('/\D+/', '', $tender->phone) ?: null);
        });
    }

    /** @return BelongsTo<User, $this> */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /** @return HasMany<TenderFile, $this> */
    public function files(): HasMany
    {
        return $this->hasMany(TenderFile::class);
    }

    public function moveTo(TenderStatus $status): bool
    {
        if ($this->status === $status) {
            return false;
        }
        $this->status = $status;
        $this->status_changed_at = now();
        if ($status === TenderStatus::Submitted) {
            $this->submitted_at ??= now();
        }

        return true;
    }

    /**
     * Moves to $status with a conditional UPDATE, so the same change sent twice at once is
     * applied (and logged) only once.
     */
    public function claimStatus(TenderStatus $status): bool
    {
        if ($this->status === $status) {
            return false;
        }
        $changes = ['status' => $status, 'status_changed_at' => now()];
        if ($status === TenderStatus::Submitted && $this->submitted_at === null) {
            $changes['submitted_at'] = now();
        }
        $claimed = static::query()->whereKey($this->getKey())->where('status', $this->getRawOriginal('status'))
            ->update(array_map(fn ($v) => $v instanceof \BackedEnum ? $v->value : $v, $changes)) === 1;
        if ($claimed) {
            $this->forceFill($changes)->syncOriginal();
        }

        return $claimed;
    }

    public function isOverdue(): bool
    {
        return $this->status->isOpen() && $this->submission_due_at->isPast();
    }

    public function isDueSoon(): bool
    {
        return $this->status->isOpen() && ! $this->submission_due_at->isPast() && $this->submission_due_at->lte(now()->addDays(self::DUE_SOON_DAYS));
    }

    /** "3 days left", "due today", "4 days overdue": for chips and the dashboard. */
    public function dueLabel(): string
    {
        if (! $this->status->isOpen()) {
            return $this->submission_due_at->format('j M Y');
        }
        $days = (int) floor(now()->startOfDay()->diffInDays($this->submission_due_at->copy()->startOfDay(), false));

        return match (true) {
            $this->submission_due_at->isPast() => 'Deadline passed',
            $days === 0 => 'Due today, '.$this->submission_due_at->format('g:i a'),
            $days === 1 => 'Due tomorrow',
            default => $days.' days left',
        };
    }

    public function dueTone(): string
    {
        return match (true) {
            $this->isOverdue() => 'critical',
            $this->isDueSoon() => 'attention',
            default => 'neutral',
        };
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeOpen(Builder $query): void
    {
        $query->whereIn('status', TenderStatus::open());
    }

    /**
     * Open and due between now and DUE_SOON_DAYS from now.
     *
     * @param  Builder<self>  $query
     */
    public function scopeDueSoon(Builder $query): void
    {
        $query->open()->whereBetween('submission_due_at', [now(), now()->addDays(self::DUE_SOON_DAYS)]);
    }

    /**
     * @param  Builder<self>  $query
     * @param  array<string, mixed>  $f
     */
    public function scopeFilter(Builder $query, array $f): void
    {
        $query
            ->when($f['status'] ?? null, fn (Builder $q, $v) => $v === 'open' ? $q->open() : $q->where('status', $v))
            ->when($f['sector'] ?? null, fn (Builder $q, $v) => $q->where('sector', $v))
            ->when($f['assigned'] ?? null, fn (Builder $q, $v) => $v === 'none' ? $q->whereNull('assigned_to') : $q->where('assigned_to', $v))
            ->when($f['due'] ?? null, fn (Builder $q) => $q->dueSoon())
            ->when($f['q'] ?? null, function (Builder $q, $term) {
                $like = '%'.str_replace(['%', '_'], ['\%', '\_'], (string) $term).'%';
                $q->where(fn (Builder $w) => $w->where('title', 'like', $like)->orWhere('entity_name', 'like', $like)
                    ->orWhere('reference', 'like', $like)->orWhere('their_reference', 'like', $like)->orWhere('contact_name', 'like', $like));
            });
    }

    public function referenceNumber(): string
    {
        return $this->reference;
    }

    public function kindLabel(): string
    {
        return 'Tender invitation';
    }

    public function area(): Area
    {
        return Area::Tenders;
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
        return array_filter([
            'Procuring entity' => $this->entity_name,
            'Tender' => $this->title,
            'Their reference' => (string) $this->their_reference,
            'Method' => $this->method->label(),
            'Location' => trim(($this->location ?? '').($this->parish ? ', '.$this->parish : ''), ', '),
            'Submission deadline' => $this->submission_due_at->format('l j F Y, g:i a'),
            'Contact' => $this->contact_name.' · '.format_phone($this->phone).' · '.$this->email,
        ]);
    }

    public function adminUrl(): string
    {
        return route('admin.tenders.show', $this);
    }

    public function nextSteps(): string
    {
        return 'Our estimating team reviews every invitation and will confirm by email whether Y.P. Seaton & Associates will bid, well before the '.$this->submission_due_at->format('j F').' deadline.';
    }
}
