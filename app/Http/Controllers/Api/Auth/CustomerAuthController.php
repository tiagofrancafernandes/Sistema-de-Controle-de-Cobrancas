<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerAuthController extends Controller
{
    public function login(Request $request): JsonResponse // WIP
    {
        $request?->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $request?->input('email'))
                ?->first()
                ?->validateWithPassword($request?->input('password'));

        $failReponse = [
            'success' => false,
            'error' => __('auth.failed'),
            'errors' => [
                'email' => __('auth.failed'),
            ],
        ];

        if (!$customer) {
            return response()->json($failReponse, 422);
        }

        $token = $customer?->createToken(
            'customer_login',
            collect([
                'ticket::create::self' => $customer?->can_open_tickets,
                'ticket::create::another' => false,
                'auth::login',
                'ticket::index::own',
            ])
                    ?->filter()
                // ?->filter(fn($item) => filled($item) && is_string($item))
                    ?->mapWithKeys(function ($value, $key): array {
                        if (!filled($value) || !is_string($value)) {
                            return [
                                $key => false,
                            ];
                        }

                        $value = trim(strval($value));

                        if (!$key || is_numeric($key)) {
                            return [
                                $value => $value,
                            ];
                        }

                        $key = trim(strval($key)) ?: $value;

                        return [
                            $key => $value,
                        ];
                    })
                    ?->keys()?->filter(fn ($item) => $item && is_string($item) && !is_numeric($item))
                    ?->toArray() ?: [
                        'auth::login',
                    ]
        );

        $responseData = [
            'success' => true,
            'customer' => collect($customer)?->except([
                'id',
                'password',
                'created_at',
                'updated_at',
                'deleted_at',
            ]),
            'access_token' => collect($token?->accessToken)
                    ?->only([
                        'id',
                        'abilities',
                        'expires_at',
                        'tokenable_type',
                    ])
                    ?->merge([
                        'token' => $token?->plainTextToken,
                    ]),
        ];

        if (!collect($responseData['access_token']['abilities'] ?? [])?->contains('auth::login')) {
            $token?->accessToken?->delete();

            return response()->json($failReponse, 422);
        }

        return response()->json($responseData, 201);
    }

    public function me(Request $request): JsonResponse // WIP
    {
        /**
         * @var ?\Laravel\Sanctum\Contracts\HasAbilities $currentAccessToken
         */
        $currentAccessToken = $request->user()?->currentAccessToken();

        if (!$currentAccessToken) {
            return response()?->json([
                'error' => $error = __('Unauthenticated.'),
                'errors' => [
                    'login' => $error,
                ]
            ], 403);
        }

        $customer = $currentAccessToken?->tokenable ?? null;

        $responseData = collect()
                ?->merge([
                    'success' => true,
                    'access_token' => collect($currentAccessToken)
                            ?->only([
                                'id',
                                'abilities',
                                'expires_at',
                                'tokenable_type',
                            ])?->merge([
                                'token' => null,
                            ]),
                ])
                ?->merge([
                    'customer' => collect($customer)?->except([
                        'id',
                        'password',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                    ]),
                ])?->toArray();

        if (!collect($responseData['access_token']['abilities'] ?? [])?->contains('auth::login')) {
            $currentAccessToken?->delete();

            return response()->json([
                'success' => false,
                'error' => __('auth.failed'),
                'errors' => [
                    'email' => __('auth.failed'),
                ],
            ], 422);
        }

        return response()?->json($responseData, 200);
    }

    public function logout(Request $request): JsonResponse // WIP
    {
        /**
         * @var ?\Laravel\Sanctum\Contracts\HasAbilities $currentAccessToken
         */
        $currentAccessToken = $request->user()?->currentAccessToken();

        if (!$currentAccessToken) {
            return response()?->json([
                'error' => $error = __('Unauthenticated.'),
                'errors' => [
                    'login' => $error,
                ]
            ], 403);
        }

        $deleted = $currentAccessToken?->delete();

        return response()?->json([
            'success' => boolval($deleted),
            'message' => __($deleted ? 'Logged out' : 'Fail to logout'),
        ], 200);
    }
}
