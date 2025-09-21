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
 * individual with 4 credits
 *      email: nancy_185964282337836_login@mail.ru
 *      password: Pearcy_password
 * 
 * legal with 3 credits
 *      email: regina_111651376314699_login@mail.ru
 *      password: Griffin_password
 */
