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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:1,2,3'],
        ]);

        $userAttributes = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
        ];

        if ($request->role === '1') {
            $client = ClientsModel::create([
                'entity_type_id' => $request->entity_type === 'legal' ? 2 : 1,
                'fullname' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);
            $userAttributes['client_id'] = $client->id;
        }

        $user = User::create($userAttributes);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
