<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Traits\CustomBelongsToTenant;
use Stancl\Tenancy\Database\Concerns\CentralConnection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// use Stancl\Tenancy\Database\Concerns\TenantConnection;

class AdminUser extends Model
{
    use HasFactory;
    use CentralConnection; // If in central schema/db
    // use TenantConnection; // If is a tenant model (only on tenant schema/db)
    // use CustomBelongsToTenant; // If has 'tenant_id' column

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tenant_id',
        'super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        //
    ];

    public function getTable()
    {
        $driver = config(sprintf('database.connections.%s.driver', config('database.default')));

        if ($driver === 'pgsql') {
            return 'public.admin_users';
        }

        return 'admin_users';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'super_admin' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the AdminUser
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the tenant that owns the AdminUser
     *
     * @return BelongsTo
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }

    public function isSuperAdmin(): bool
    {
        if (!is_null($this->tenant_id)) {
            return false;
        }

        return is_null($this->tenant_id) && $this->super_admin;
    }
}
