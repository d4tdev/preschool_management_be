<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidAuthException;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
        $this->middleware(
            'auth:api',
            [
                'except' => [
                    'login',
                    'refresh',
                    'register',
                    'listUser'
                ],
            ]
        );
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        $token = $this->authService->login($request);

        if (!$token) {
            throw new InvalidAuthException('auth.invalid', 401);
        }

        return $this->createNewToken($token);
    }

    public function createNewToken(string $token, $isRefresh = false)
    {
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ];
        if (!$isRefresh) {
            $data['user'] = auth()->user();
        }

        return response()->json(['code' => 200, 'data' => $data]);
    }

    public function register(Request $request)
    {
        $user = $this->authService->register($request);
        return response()->json(['code' => 200, 'data' => $user]);
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->refresh(), true);
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();
        $this->authService->updatePassword($user, $request);
        return response()->json(['success' => true]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function listUser(Request $request)
    {
        $filters = $request->input('filters', []);
        $sorts = $request->input('sorts', []);
        $search = $request->input('search', []);
        $limit = $request->input('limit', 10);
        $list = $this->authService->listUser($filters, $sorts, $search, $limit);

        return response()->json(['code' => 200, 'data' => UserResource::collection($list)]);
    }
}
