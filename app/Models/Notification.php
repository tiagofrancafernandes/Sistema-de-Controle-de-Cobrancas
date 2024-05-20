<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Support\Carbon|null $to_sent_on
 * @property \Illuminate\Support\Carbon|null $was_sent_on
 * @property string $notifier_uuid
 * @property string $customer_uuid
 * @property \Illuminate\Support\Collection|null $data
 * @property string|null $errors
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\NotificationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCustomerUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereErrors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereNotifierUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereToSentOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereWasSentOn($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'to_sent_on',
        'was_sent_on',
        'notifier_uuid',
        'customer_uuid',
        'data',
        'errors',
    ];

    protected $casts = [
        'to_sent_on' => 'datetime',
        'was_sent_on' => 'datetime',
        'data' => AsCollection::class,
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
