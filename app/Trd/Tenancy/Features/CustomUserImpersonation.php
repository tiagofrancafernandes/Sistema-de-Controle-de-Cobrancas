<?php

declare(strict_types=1);

namespace App\Trd\Tenancy\Features;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Contracts\Feature;
// use Stancl\Tenancy\Contracts\Tenant;
use Stancl\Tenancy\Database\Models\ImpersonationToken;
use Stancl\Tenancy\Tenancy;
use App\Models\Tenant;

class CustomUserImpersonation implements Feature
{
    public static $ttl = 60; // seconds

    public function bootstrap(Tenancy $tenancy): void
    {
        $tenancy->macro('impersonate', function (Tenant|string $tenant, string $userId, string $redirectUrl, ?string $authGuard = null): ImpersonationToken {
            /**
             * @var Tenant $tenant
             */
            $tenant = Tenant::tenantOrInit($tenant);

            return ImpersonationToken::create([
                'tenant_id' => $tenant->getTenantKey(),
                'user_id' => $userId,
                'redirect_url' => $redirectUrl,
                'auth_guard' => $authGuard,
            ]);
        });
    }

    /**
     * Impersonate a user and get an HTTP redirect response.
     *
     * @param string|ImpersonationToken $token
     * @param int $ttl
     * @return RedirectResponse
     */
    public static function makeResponse($token, null|string|int $ttl = null): RedirectResponse
    {
        $token = $token instanceof ImpersonationToken ? $token : ImpersonationToken::findOrFail($token);
        abort_unless($token instanceof ImpersonationToken, 403);

        if (((string) $token->tenant_id) !== ((string) tenant()->getTenantKey())) {
            abort(403);
        }

        $ttl ??= static::$ttl;

        if ($token->created_at->diffInSeconds(Carbon::now()) > $ttl) {
            abort(403);
        }

        // TODO
        dd( //WIP
            $ttl,
            $token,
            $token->user_id,
            // auth()->user(),
            auth()->user()?->name,
            tenant()->getTenantKey(),
            $token->tenant_id,
        );

        Auth::guard($token->auth_guard)->loginUsingId($token->user_id);

        $token->delete();

        return redirect($token->redirect_url);
    }
}
