<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
