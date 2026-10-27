<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Tender documents sent with an invitation. Private disk only; streamed to estimating staff.
 *
 * @property int $id
 * @property int $tender_id
 * @property string $path
 * @property string $original_name
 * @property string|null $mime
 * @property int $size
 * @property-read Tender $tender
 */
class TenderFile extends Model
{
    protected $fillable = ['path', 'original_name', 'mime', 'size'];

    /** @return BelongsTo<Tender, $this> */
    public function tender(): BelongsTo
    {
        return $this->belongsTo(Tender::class);
    }
}
