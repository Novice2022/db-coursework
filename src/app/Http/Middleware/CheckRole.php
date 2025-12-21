<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, int $role): Response
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        if ($user->role_id === $role) {
            return $next($request);
        }
        
        abort(403, 'У вас нет доступа к этой странице');
    }
}