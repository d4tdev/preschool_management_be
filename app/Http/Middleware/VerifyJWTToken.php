<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $payload = JWTAuth::parseToken()->payload();
            $lastUpdateUser = Carbon::parse($user->updated_at);

            $iat = Carbon::parse($payload->get('iat'))->timezone(config('app.timezone'));
            if ($lastUpdateUser->gte($iat)) {
                return \response()->json(['message' => 'token.invalid'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (TokenExpiredException $e) {
            return \response()->json(['message' => 'token.expired'], Response::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException $e) {
            return \response()->json(['message' => 'token.invalid'], Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return \response()->json(['message' => 'token.required'], Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
