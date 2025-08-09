<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ClientRepository;
use App\Http\Repositories\CreditRepository;
use App\Models\User;

class ClientController extends Controller
{
    public function index(int $id) {
        $data = [];

        $client = User::find($id) -> client;

        if ($client -> entityType -> id === 1) {
            $data['info'] = ClientRepository::getIndividualEntityInfo($client -> id);
        } else {
            $data['info'] = ClientRepository::getLegalEntityInfo($client -> id);
        }

        $credits = CreditRepository::getCredits($client -> id);

        // foreach ($credits as $key => $credit) {

        // }

        $data['credits'] = $credits;

        return view('client', $data);
    }
}

/**
 * individual with 3 credits
 *      client_id: 43e9fb13-135e-466b-a4e3-2e2f04387af3
 *      email: tommy_50779469150963_login@mail.ru
 *      password: Brown_password
 */
