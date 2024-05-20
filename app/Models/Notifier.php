<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifier extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'title',
        'notifier_class',
        'config',
        'enabled',
    ];

    protected $casts = [
        'config' => AsCollection::class,
        'enabled' => 'boolean',
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
