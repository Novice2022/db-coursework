<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ReportAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $reportType = $request->route('type') ?? $request->get('type');
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        switch ($reportType) {
            case 'clients':
            case 'financial':
                if (!$user->isManager() && !$user->isAdmin()) {
                    abort(403, 'У вас нет доступа к этому отчету');
                }
                break;
            case 'risk':
                if (!$user->isAnalyst() && !$user->isAdmin()) {
                    abort(403, 'У вас нет доступа к этому отчету');
                }
                break;
        }
        
        return $next($request);
    }
}