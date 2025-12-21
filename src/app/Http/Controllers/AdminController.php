<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CreditTypeModel;
use App\Models\EntityTypeModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_clients' => User::where('role_id', 1)->count(),
            'managers' => User::where('role_id', 2)->count(),
            'analysts' => User::where('role_id', 3)->count(),
            'admins' => User::where('role_id', 4)->count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
    
    public function users(Request $request)
    {
        $query = User::with(['role', 'client']);
        
        if ($request->has('role_id')) {
            $query->where('role_id', $request->get('role_id'));
        }
        
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(20);
            
        return view('admin.users', compact('users'));
    }
    
    public function creditTypes()
    {
        $creditTypes = CreditTypeModel::with('entityType')
            ->orderBy('name')
            ->get();
            
        return view('admin.credit-types', compact('creditTypes'));
    }

    public function settings()
    {
        $settings = [
            'app_name' => config('app.name'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'db_connection' => config('database.default'),
            'mail_driver' => config('mail.default'),
            'cache_driver' => config('cache.default'),
        ];
        
        return view('admin.settings', compact('settings'));
    }

    public function reports()
    {
        $reportTypes = [
            'users' => 'Отчет по пользователям',
            'credits' => 'Отчет по кредитам',
            'financial' => 'Финансовый отчет',
            'audit' => 'Аудит системы',
        ];
        
        return view('admin.reports', compact('reportTypes'));
    }

    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|integer|in:1,2,3,4',
            'client_id' => 'nullable|uuid|exists:clients,id',
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        
        $user = User::create($validated);
        
        return redirect()->route('admin.users')
            ->with('success', 'Пользователь успешно создан');
    }

    public function updateUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|integer|in:1,2,3,4',
            'client_id' => 'nullable|uuid|exists:clients,id',
        ]);
        
        if ($request->has('password') && $request->password) {
            $validated['password'] = Hash::make($request->password);
        }
        
        $user->update($validated);
        
        return redirect()->route('admin.users')
            ->with('success', 'Пользователь успешно обновлен');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        
        if ($user->id === Auth::user()->id) {
            return redirect()->route('admin.users')
                ->with('error', 'Нельзя удалить собственный аккаунт');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')
            ->with('success', 'Пользователь успешно удален');
    }

    public function createCreditType(Request $request)
    {
        $validated = $request->validate([
            'entity_type_id' => 'required|integer|exists:entity_type,id',
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'min_term' => 'nullable|integer|min:1',
            'max_term' => 'nullable|integer|min:1',
            'base_rate' => 'nullable|numeric|min:0|max:100',
        ]);
        
        CreditTypeModel::create($validated);
        
        return redirect()->route('admin.credit-types')
            ->with('success', 'Тип кредита успешно создан');
    }

    public function updateCreditType(Request $request, $typeId)
    {
        $creditType = CreditTypeModel::findOrFail($typeId);
        
        $validated = $request->validate([
            'entity_type_id' => 'required|integer|exists:entity_type,id',
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|min:0',
            'min_term' => 'nullable|integer|min:1',
            'max_term' => 'nullable|integer|min:1',
            'base_rate' => 'nullable|numeric|min:0|max:100',
        ]);
        
        $creditType->update($validated);
        
        return redirect()->route('admin.credit-types')
            ->with('success', 'Тип кредита успешно обновлен');
    }

    public function deleteCreditType($typeId)
    {
        $creditType = CreditTypeModel::findOrFail($typeId);
        
        if ($creditType->credits()->count() > 0) {
            return redirect()->route('admin.credit-types')
                ->with('error', 'Нельзя удалить тип кредита, к которому привязаны кредиты');
        }
        
        $creditType->delete();
        
        return redirect()->route('admin.credit-types')
            ->with('success', 'Тип кредита успешно удален');
    }
    
    public function entityTypes()
    {
        $entityTypes = EntityTypeModel::all();
        return view('admin.entity-types', compact('entityTypes'));
    }
    
    public function createEntityType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:16|unique:entity_type,name',
        ]);
        
        EntityTypeModel::create($validated);
        
        return redirect()->route('admin.entity-types')
            ->with('success', 'Тип организации успешно создан');
    }
}