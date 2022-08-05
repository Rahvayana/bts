<?php

namespace App\Http\Middleware;

use Closure;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;

class AdministratorMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->role_id != 1){
            return response()->json(array(
                "code" => ResponseStatus::HTTP_FORBIDDEN,
                "message" => 'FORBIDDEN'
            ),ResponseStatus::HTTP_FORBIDDEN);
        }
        return $next($request);
    }
}
