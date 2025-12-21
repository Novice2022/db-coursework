<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Редирект в зависимости от роли
        switch ($user->role_id) {
            case 1: // Клиент
                return redirect()->route('client.dashboard');
                
            case 2: // Менеджер
                return redirect()->route('manager.dashboard');
                
            case 3: // Аналитик
                return redirect()->route('analyst.dashboard');
                
            case 4: // Администратор
                return redirect()->route('admin.dashboard');
                
            default:
                return view('dashboard.default');
        }
    }
}