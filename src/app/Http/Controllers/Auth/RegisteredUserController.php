<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Models\CompanyIndustry;
use App\Models\CreditHistory;
use App\Models\IndividualEntity;
use App\Models\LegalEntity;
use App\Models\Profitability;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'industries' => CompanyIndustry::all(),
            'profitabilities' => Profitability::all(),
            'credit_histories' => CreditHistory::all()
        ]);
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
            'role' => ['required', 'string', 'in:1,2,3'],
        ]);

        $userAttributes = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role,
            'client' => null
        ];

        if ($request->role === '1') {
            $client = Client::create([
                'id' => (string) Str::uuid(),
                'entity_type_id' => $request->entity_type,
                'fullname' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            $userAttributes['client'] = $client -> id;

            $request -> validate([
                'entity_type' => ['required', 'string', 'in:individual,legal']
            ]);

            if ($request -> entity_type === 'individual') {
                $request -> validate([
                    'income' => ['required', 'number']
                ]);

                IndividualEntity::create([
                    'client_id' => $client -> id,
                    'credit_history_id' => 6,
                    'income' => $request -> income
                ]);
            }
            else {
                $request -> validate([
                    'industry' => ['required', 'string', 'between:1,20'],
                    'profitability' => ['required', 'string', 'between:1,7'],
                    'guarantee' => ['required', 'string', 'min:1000000'],
                ]);

                LegalEntity::create([
                    'client_id' => $client -> id,
                    'industry_id' => $request -> industry,
                    'profitability_id' => $request -> profitability,
                    'guarantee_amount' => $request -> guarantee,
                ]);
            }
        }
        
        $user = User::create($userAttributes);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
