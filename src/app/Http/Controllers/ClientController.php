<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\CreditTypeRepository;
use App\Models\ClientsModel;
use App\Models\User;
use App\Models\CreditsModel;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $client = $user->client;
        
        if (!$client) {
            if ($user->role_id === 1) {
                $client = ClientsModel::create([
                    'id' => \Illuminate\Support\Str::uuid(),
                    'entity_type_id' => 1,
                    'fullname' => $user->name,
                    'phone' => '',
                    'address' => '',
                    'registration_date' => now(),
                ]);
                
                $user->client_id = $client->id;
                $user->save();
            } else {
                abort(404, 'Клиент не найден');
            }
        }
        
        $credits = $client->credits()
            ->with(['creditType'])
            ->orderBy('start_date', 'desc')
            ->get();
            
        return view('dashboard.client', compact('client', 'credits'));
    }
    
    public function credits(Request $request)
    {
        $user = $request->user();
        $client = $user->client;
        
        $credits = $client->credits()->with(['creditType', 'payments'])
            ->orderBy('start_date', 'desc')
            ->paginate(10);
            
        return view('client.credits', compact('client', 'credits'));
    }
    
    public function show(string $userId)
    {
        $user = User::findOrFail($userId);
        $client = $user->client;
        
        if (!$client) {
            abort(404, 'Клиент не найден');
        }
        
        $data = ['client_id' => $client->id];

        if ($client->entityType->id === 1) {
            $data['entityType'] = 'individual';
            $data['info'] = ClientRepository::getIndividualEntityInfo($client->id);
        } else {
            $data['entityType'] = 'legal';
            $data['info'] = ClientRepository::getLegalEntityInfo($client->id);
        }

        $credits = CreditsModel::where('client_id', $client->id)
            ->with('creditType')
            ->get()
            ->map(function($credit) {
                return [
                    'id' => $credit->id,
                    'name' => $credit->creditType->name,
                    'amount' => $credit->amount,
                    'rate' => $credit->rate,
                    'term' => $credit->term,
                    'start_date' => $credit->start_date->format('Y-m-d'),
                ];
            });
        $data['credits'] = $credits;
        $data['creditTypes'] = CreditTypeRepository::getCreditTypes();

        return view('client.show', $data);
    }
    
    public function applications(Request $request)
    {
        $user = $request->user();
        $client = $user->client;
        
        $applications = collect();
        
        return view('client.applications', compact('client', 'applications'));
    }
}

/**
 * individual with 4 credits
 *      email: nancy_185964282337836_login@mail.ru
 *      password: Pearcy_password
 * 
 * legal with 3 credits
 *      email: regina_111651376314699_login@mail.ru
 *      password: Griffin_password
 */
