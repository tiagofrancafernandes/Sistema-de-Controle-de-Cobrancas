<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use App\Models\Traits\TenantModelHelpers;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasFactory;
    // use HasUuids;
    use HasDatabase;
    use HasDomains;
    use TenantModelHelpers;

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'plan',
        ];
    }

    /**
     * Get all of the adminUsers for the Tenant
     *
     * @return HasMany
     */
    public function adminUsers(): HasMany
    {
        return $this->hasMany(AdminUser::class, 'tenant_id', 'id')->whereNotNull('tenant_id');
    }

    /**
     * Get all of the superAdminUsers for the Tenant
     *
     * @return HasMany
     */
    public function superAdminUsers(): HasMany
    {
        return $this->hasMany(AdminUser::class, 'tenant_id', 'id')->whereNull('tenant_id');
    }
}
