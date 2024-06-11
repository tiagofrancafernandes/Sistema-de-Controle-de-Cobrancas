<?php

declare(strict_types=1);

use App\Trd\Tenancy\Features\CustomUserImpersonation;

// use Illuminate\Support\Facades\Route;
// use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
// use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
// use Stancl\Tenancy\Middleware\InitializeTenancyByPath;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

// Route::middleware([
//     'web',
//     InitializeTenancyByDomain::class,
//     PreventAccessFromCentralDomains::class,
// ])
//     ->prefix('tn')
//     ->group(base_path('routes/tenant-path.php'));

// We're in your tenant routes!
Route::get(
    '/impersonate/{token}/{ttl?}',
    fn ($token, $ttl = null) => CustomUserImpersonation::makeResponse($token, $ttl)
)
->where('ttl', '[0-9]*')
->name('tenant_');
