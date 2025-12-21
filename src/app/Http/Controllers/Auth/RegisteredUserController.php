<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ClientsModel;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:1,2,3,4'],
        ];

        if ($request->role === '1') {
            $rules['entity_type'] = ['required', 'in:individual,legal'];
            $rules['phone'] = ['nullable', 'string', 'max:20', 'regex:/^[\d\s\-\+\(\)]+$/'];
            $rules['address'] = ['nullable', 'string', 'max:255'];
        }

        $request->validate($rules);

        $userAttributes = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
        ];

        if ($request->role === '1') {
            $clientData = [
                'id' => \Illuminate\Support\Str::uuid(),
                'entity_type_id' => $request->entity_type === 'legal' ? 2 : 1,
                'fullname' => $request->name,
                'registration_date' => now(),
            ];

            if ($request->filled('phone')) {
                $clientData['phone'] = $request->phone;
            }
            
            if ($request->filled('address')) {
                $clientData['address'] = $request->address;
            }

            $client = ClientsModel::create($clientData);
            $userAttributes['client_id'] = $client->id;
        }

        $user = User::create($userAttributes);

        event(new Registered($user));

        Auth::login($user);

        return match($user->role_id) {
            1 => redirect()->route('client.dashboard'),
            2 => redirect()->route('manager.dashboard'),
            3 => redirect()->route('analyst.dashboard'),
            4 => redirect()->route('admin.dashboard'),
            default => redirect()->route('dashboard'),
        };
    }
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],
    //         'role' => ['required', 'in:1,2,3'],
    //     ]);

    //     $userAttributes = [
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'role_id' => $request->role,
    //     ];

    //     if ($request->role === '1') {
    //         $client = ClientsModel::create([
    //             'entity_type_id' => $request->entity_type === 'legal' ? 2 : 1,
    //             'fullname' => $request->name,
    //             'phone' => $request->phone,
    //             'address' => $request->address
    //         ]);
    //         $userAttributes['client_id'] = $client->id;
    //     }

    //     $user = User::create($userAttributes);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect()->route('dashboard');
    // }
}
