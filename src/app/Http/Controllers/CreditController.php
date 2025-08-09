<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CreditRepository;

class CreditController {
    public function show(string $id) {
        $data = [
            'credit' => CreditRepository::getCredit($id),
            'payments' => CreditRepository::getCreditPayments($id),
            'fines' => CreditRepository::getCreditFines($id)
        ];

        return view('credit', $data);
    }
}
