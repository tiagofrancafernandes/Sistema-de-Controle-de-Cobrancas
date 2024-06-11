<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\CustomBelongsToTenant;
use Illuminate\Database\Eloquent\Relations\HasOne;

// use Stancl\Tenancy\Database\Concerns\CentralConnection;
// use Stancl\Tenancy\Database\Concerns\TenantConnection;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    // use CentralConnection;
    // use TenantConnection;
    use CustomBelongsToTenant;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getTable()
    {
        if (config('database.default') === 'sqlite') {
            return parent::getTable();
        }

        return 'public.users';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the adminUser associated with the User
     *
     * @return HasOne
     */
    public function adminUser(): HasOne
    {
        if ($tenantId = $this->tenant_id) {
            return $this->hasOne(AdminUser::class, 'user_id', 'id')
                ->whereNotNull('tenant_id')
                ->where('tenant_id', $tenantId);
        }

        return $this->hasOne(AdminUser::class, 'user_id', 'id')->whereNull('tenant_id');
    }

    public function superAdmin(): bool
    {
        /**
         * @var AdminUser $adminUser
         */
        $adminUser = $this->adminUser ?? null;

        if (!$adminUser) {
            return false;
        }

        return is_null($adminUser?->tenant_id) && $adminUser?->isSuperAdmin();
    }
}
