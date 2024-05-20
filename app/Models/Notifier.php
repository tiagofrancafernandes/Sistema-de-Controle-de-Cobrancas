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
 * @property string $title
 * @property string $notifier_class
 * @property \Illuminate\Support\Collection|null $config
 * @property bool $enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\NotifierFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereNotifierClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notifier whereUuid($value)
 * @mixin \Eloquent
 */
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
