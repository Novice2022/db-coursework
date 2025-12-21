<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStoreRequest;
use App\Models\PaymentsModel;
use App\Models\CreditsModel;

class PaymentController extends Controller
{
    public function store(PaymentStoreRequest $request, string $creditId)
    {
        $data = $request->validated();
        
        PaymentsModel::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'credit_id' => $creditId,
            'amount' => $data['amount'],
            'datetime' => $data['datetime'] ?? now(),
        ]);

        return redirect()->route('credits.show', $creditId)
            ->with('success', 'Платеж успешно добавлен');
    }
    
    public function create(string $creditId)
    {
        $credit = CreditsModel::with(['creditType', 'payments'])->find($creditId);
        if (!$credit) {
            abort(404, 'Кредит не найден');
        }
        
        return view('payments.create', compact('credit'));
    }
}