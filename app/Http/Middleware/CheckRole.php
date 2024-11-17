<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::guard('api')->user();
        if(!$user)
        {
            return response()->json(['!$user ||$user->role !== $role']);
        }
        return $next($request);
        

    }

    }
