<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\CreditRepository;
use App\Http\Repositories\CreditTypeRepository;
use App\Models\User;

class ClientController extends Controller
{
    public function index(int $userId) {
        $client = User::find($userId) -> client;
        
        $data = ['client_id' => $client -> id];

        if ($client -> entityType -> id === 1) {
            $data['entityType'] = 'individual';
            $data['info'] = ClientRepository::getIndividualEntityInfo($client -> id);
        } else {
            $data['entityType'] = 'legal';
            $data['info'] = ClientRepository::getLegalEntityInfo($client -> id);
        }

        $credits = CreditRepository::getCredits($client -> id);

        $data['credits'] = $credits;
        $data['creditTypes'] = CreditTypeRepository::getCreditTypes();

        return view('client', $data);
    }
}

/**
 * individual with 3 credits
 *      client_id: 43e9fb13-135e-466b-a4e3-2e2f04387af3
 *      email: tommy_50779469150963_login@mail.ru
 *      password: Brown_password
 */
