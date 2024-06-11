<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InitializeTenantIfHasOne
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()) {
            return $next($request);
        }

        $userTenantId = auth()->user()?->tenant_id;

        if ($userTenantId) {
            /**
             * @var Tenant $tenant
             */
            $tenant = Tenant::findOrFail($userTenantId);
            $tenant->init();

            abort_if(!tenancy()?->initialized, 404);
        }

        if (tenant('id') !== $userTenantId) {
            abort(404);
        }

        return $next($request);
    }
}
