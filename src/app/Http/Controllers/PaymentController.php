<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Models\PaymentsModel;

class PaymentController {
    public function store(PaymentStoreRequest $request, string $creditId) {
        $data = $request->validated();
        
        PaymentsModel::create([
            'credit_id' => $creditId,
            'amount' => $data['amount'],
            'datetime' => now(),
        ]);

        return back()->with('success', 'Платеж успешно добавлен');
    }
    
    public function create(string $creditId)
    {
        $credit = \App\Models\CreditsModel::find($creditId);
        return view('payments.create', compact('credit'));
    }
}