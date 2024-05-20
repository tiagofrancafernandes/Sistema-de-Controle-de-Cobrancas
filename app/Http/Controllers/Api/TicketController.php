<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function index(Request $request): JsonResponse
    {
        /**
         * @var ?\App\Models\Customer $customerUser
         */
        $customerUser = $request->user();

        /**
         * @var ?\Laravel\Sanctum\Contracts\HasAbilities $currentAccessToken
         */
        $currentAccessToken = $customerUser?->currentAccessToken();

        if (!$currentAccessToken) {
            return response()?->json([
                'error' => $error = __('Unauthenticated.'),
                'errors' => [
                    'login' => $error,
                ]
            ], 403);
        }

        $orderBy = filter_var($request?->input('orderBy', 'id'), FILTER_DEFAULT, FILTER_NULL_ON_FAILURE);
        $direction = filter_var($request?->input('direction', 'desc'), FILTER_DEFAULT, FILTER_NULL_ON_FAILURE);
        $orderBy = collect(['id', 'name'])?->contains($orderBy) ? $orderBy : 'id';
        $orderDirection = in_array(strtolower(strval($direction)), ['asc', 'desc']) ? $direction : 'desc';

        $query = Ticket::byEmail($customerUser?->email ?? '')
                ?->orderBy($orderBy, $orderDirection);

        $query = $query?->select([
            'id',
            'trackid',
            'name',
            'email',
            'category',
            'priority',
            'subject',
            'message',
            'message_html',
            'dt',
            'lastchange',
            'status',
            'openedby',
            'replies',
            'staffreplies',
            'owner',
            'assignedby',
            'time_worked',
            'lastreplier',
            'replierid',
            'archive',
            'locked',
            'history',
        ]);

        return response()?->json($query?->paginate(15));
    }
}
