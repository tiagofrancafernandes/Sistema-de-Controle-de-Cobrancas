<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'know_about_us_by',
        'customer_since',
        'doc1_type',
        'doc1',
        'phones',
        'extra_data',
        'internal_note',
        'email_for_billing',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'know_about_us_by' => 'datetime',
            'phones' => AsCollection::class,
            'emails' => AsCollection::class,
            'extra_data' => AsCollection::class,
        ];
    }

    protected $datetimes = [
        'customer_since',
    ];

    protected $hidden = [
        'internal_note',
        'password',
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

    public function passwordIsValid(string $password): bool
    {
        return Hash::check($password, $this?->password);
    }

    public function validateWithPassword(string $password): ?static
    {
        return Hash::check($password, $this?->password) ? $this : null;
    }
}
