<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CreditRepository;
use App\Http\Services\CreditService;
use Illuminate\Http\Response;

class CreditController {
    public function index(string $id) {
        $data = [
            'credit' => CreditRepository::getCredit($id)
        ];
        
        $payments = CreditRepository::getCreditPayments($id);
        $fines = CreditRepository::getCreditFines($id);
        
        $data['payments'] = $payments -> isEmpty() ? null : $payments;
        $data['fines'] = $fines -> isEmpty() ? null : $fines;
        $data['remains'] = CreditService::calculateCreditRemains($data['credit'], $payments);

        // return Response($data, 200);

        return view('credit', $data);
    }
}
