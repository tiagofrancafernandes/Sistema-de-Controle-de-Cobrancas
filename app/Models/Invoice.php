<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\InvoiceStatus;
use App\Enums\InvoiceOverdueNotifyCycle;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $recurrence_uuid
 * @property InvoiceStatus $status
 * @property string|null $extra_text
 * @property float $amount
 * @property \Illuminate\Support\Carbon $due_date
 * @property \Illuminate\Support\Collection|null $notifiers
 * @property InvoiceOverdueNotifyCycle $overdue_notify_cycle
 * @property \Illuminate\Support\Collection|null $content_data
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\InvoiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereContentData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereExtraText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereNotifiers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereOverdueNotifyCycle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereRecurrenceUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice withoutTrashed()
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'customer_uuid',
        'recurrence_uuid',
        'status',
        'extra_text',
        'amount',
        'due_date',
        'notifiers',
        'overdue_notify_cycle',
        'content_data',
    ];

    protected $casts = [
        'status' => InvoiceStatus::class,
        'amount' => 'double',
        'due_date' => 'datetime',
        'notifiers' =>  AsCollection::class,
        'overdue_notify_cycle' => InvoiceOverdueNotifyCycle::class,
        'content_data' =>  AsCollection::class,
    ];

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds(): array
    {
        return [
            'uuid',
        ];
    }

    /**
     * Get the customer that owns the Invoice
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_uuid', 'uuid');
    }

    /**
     * Get the recurrence that owns the Invoice
     *
     * @return BelongsTo
     */
    public function recurrence(): BelongsTo
    {
        return $this->belongsTo(Recurrence::class, 'recurrence_uuid', 'uuid');
    }
}
