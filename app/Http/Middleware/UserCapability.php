<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use JWTAuth;

class UserCapability
{

    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if(!$user){
            return response()->json(["error" => "User not found"], 404);
        }

        if(!in_array($user->role, $roles)){
            return response()->json(["error" => "User not authorized"], 401);
        }

        return $next($request);
    }


}
