<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Stancl\Tenancy\Contracts\Tenant;
// use Stancl\Tenancy\Database\TenantScope;
use App\Models\Scopes\CustomTenantScope;

/**
 * @property-read Tenant $tenant
 */
trait CustomBelongsToTenant
{
    public static $tenantIdColumn = 'tenant_id';

    public function tenant()
    {
        return $this->belongsTo(config('tenancy.tenant_model'), static::$tenantIdColumn);
    }

    public static function bootCustomBelongsToTenant()
    {
        static::addGlobalScope(new CustomTenantScope());

        static::creating(function ($model) {
            if (! $model->getAttribute(static::$tenantIdColumn) && ! $model->relationLoaded('tenant')) {
                if (tenancy()->initialized) {
                    $model->setAttribute(static::$tenantIdColumn, tenant()->getTenantKey());
                    $model->setRelation('tenant', tenant());
                }
            }
        });
    }
}
