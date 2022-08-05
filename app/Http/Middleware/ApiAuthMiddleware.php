<?php

namespace App\Http\Middleware;
use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Crypt;

class ApiAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        try {
            $credentials = JWT::decode($token, env("APP_KEY"), ['HS256']);
            $request->request->add(['auth_id' => $credentials->id]);
            $request->request->add(['role_id' => Crypt::decryptString($credentials->role_id)]);

        } catch(ExpiredException $e) {
            return response()->json(array(
                "code" => 401,
                "message" => 'EXPIRED TOKEN'
            ),401);
        } catch(\Exception $e) {
            return response()->json(array(
                "code" => 401,
                "message" => "UNAUTHORIZED"
            ),401);
        }

        return $next($request);
    }
}
