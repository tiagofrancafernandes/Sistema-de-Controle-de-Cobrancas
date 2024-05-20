<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RecurrenceMode;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Support\Carbon $start_date
 * @property string $contract_uuid
 * @property bool $dispatch_actions
 * @property bool $active
 * @property float $amount
 * @property RecurrenceMode $mode
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\RecurrenceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereContractUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereDispatchActions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Recurrence withoutTrashed()
 * @mixin \Eloquent
 */
class Recurrence extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'start_date',
        'contract_uuid',
        'dispatch_actions',
        'active',
        'amount',
        'mode',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'dispatch_actions' => 'boolean',
        'active' => 'boolean',
        'amount' => 'double',
        'mode' => RecurrenceMode::class,
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
}
