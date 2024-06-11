<?php

namespace App\Models\Traits;

use App\Models\Tenant;

trait TenantModelHelpers
{
    public function initialize(): null|bool|Tenant
    {
        if (!is_a($this, Tenant::class)) {
            return false;
        }

        tenancy()->initialize($this);

        return tenant();
    }

    public function init(): null|bool|Tenant
    {
        return $this->initialize();
    }

    public static function initialized(): null|Tenant
    {
        return tenancy()->tenant;
    }

    public function initializedAsThis(): bool
    {
        if (!is_a($this, Tenant::class)) {
            return false;
        }

        return boolval(tenancy()->tenant?->id == $this->{'id'} ?? null);
    }

    public static function end(): void
    {
        tenancy()->end();
    }

    public static function initById(int|string $tenantId): null|bool|Tenant
    {
        return static::initializeById($tenantId);
    }

    public static function initializeById(int|string $tenantId): null|bool|Tenant
    {
        $tenant = static::where('id', $tenantId)->first();

        if (!$tenant) {
            return false;
        }

        tenancy()->initialize($tenant);

        return static::initialized();
    }

    public static function tenantOrInit(null|int|string|Tenant $tenant): null|Tenant
    {
        if (is_null($tenant)) {
            return null;
        }

        /**
         * @var Tenant $tenant
         */
        $tenant = is_a($tenant, Tenant::class) ? $tenant : static::initializeById($tenant);

        return $tenant ?: null;
    }
}
