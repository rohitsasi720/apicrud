<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        Auth::routes(['verify' => true]);
        //dd($user->role);
        //dd($user);
        //dd($roles);
        
        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
        
        //dd(in_array($user->role, $roles));
        //dd(in_array('2',['2']));
        if (!in_array($user->role, $roles)) {
            //dd($user->role);
            return response()->json(['message' => 'You are not authorized to access this resource.'], 403);
        }

        return $next($request);
    }
}