<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
// use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use App\Models\Traits\CustomBelongsToTenant;

class CustomTenantScope implements Scope
{
    use CustomBelongsToTenant;

    public function apply(Builder $builder, Model $model)
    {
        if (! tenancy()->initialized) {
            return;
        }

        $builder->where($model->qualifyColumn(static::$tenantIdColumn), tenant()->getTenantKey());
    }

    public function extend(Builder $builder)
    {
        $builder->macro('withoutTenancy', fn (Builder $builder) => $builder->withoutGlobalScope($this));
    }
}
