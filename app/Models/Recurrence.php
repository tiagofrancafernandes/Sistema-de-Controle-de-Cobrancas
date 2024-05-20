<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\RecurrenceMode;
use Illuminate\Database\Eloquent\SoftDeletes;

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
