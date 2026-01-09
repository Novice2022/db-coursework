<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoleModel;
use App\Models\ClientsModel;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'totalUsers' => User::count(),
            'activeUsers' => User::whereNotNull('email_verified_at')->count(),
            'totalClients' => ClientsModel::count(),
            'roles' => RoleModel::all(),
        ];
        
        $roleCounts = [];
        foreach ($stats['roles'] as $role) {
            $roleCounts[$role->id] = User::where('role_id', $role->id)->count();
        }
        
        $recentUsers = User::with(['role', 'client.entityType'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        return view('admin.dashboard', compact('stats', 'recentUsers', 'roleCounts'));
    }
    
    public function users()
    {
        $users = User::with(['role', 'client.entityType'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.users', compact('users'));
    }
    
    public function settings()
    {
        return view('admin.settings');
    }
    
    public function audit()
    {
        return view('admin.audit');
    }
}