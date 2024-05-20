<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\InvoiceStatus;
use App\Enums\InvoiceOverdueNotifyCycle;

class Invoice extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
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
}
