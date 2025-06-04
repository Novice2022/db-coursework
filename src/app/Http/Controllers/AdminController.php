<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::with(['role', 'client'])->get();
        $roles = Role::all();
        
        return view('admin.users', compact('users', 'roles'));
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function logs()
    {
        $logs = [];
        if (file_exists(storage_path('logs/laravel.log'))) {
            $logs = file(storage_path('logs/laravel.log'));
            $logs = array_reverse($logs);
        }
        
        return view('admin.logs', compact('logs'));
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:role,id',
            'client_id' => 'nullable|exists:clients,id',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role_id = $validated['role_id'];
        $user->client_id = $validated['client_id'] ?? null;
        $user->save();

        Log::info("Admin created new user", ['user_id' => $user->id]);

        return redirect()->route('admin.users')
            ->with('success', 'Пользователь успешно создан');
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:role,id',
            'client_id' => 'nullable|exists:clients,id',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];
        $user->client_id = $validated['client_id'] ?? null;
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        Log::info("Admin updated user", ['user_id' => $user->id]);

        return redirect()->route('admin.users')
            ->with('success', 'Пользователь успешно обновлен');
    }

    public function destroyUser(User $user)
    {
        $user->delete();

        Log::info("Admin deleted user", ['user_id' => $user->id]);

        return redirect()->route('admin.users')
            ->with('success', 'Пользователь успешно удален');
    }
}