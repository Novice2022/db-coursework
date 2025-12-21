<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CreditRepository;
use App\Http\Services\CreditService;
use App\Models\CreditsModel;
use App\Models\CreditTypeModel;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function index(string $creditId)
    {
        $data = [
            'credit' => CreditRepository::getCredit($creditId)
        ];
        
        if (!$data['credit']) {
            abort(404, 'Кредит не найден');
        }
        
        $payments = CreditRepository::getCreditPayments($creditId);
        $fines = CreditRepository::getCreditFines($creditId);
        
        $data['payments'] = $payments->isEmpty() ? null : $payments;
        $data['fines'] = $fines->isEmpty() ? null : $fines;
        
        $creditModel = CreditsModel::find($creditId);
        if ($creditModel) {
            $data['remains'] = CreditService::calculateCreditRemains($creditModel, $payments);
        } else {
            $data['remains'] = ['creditAmountRemains' => 0, 'monthlyPayment' => 0];
        }

        return view('credit', $data);
    }
    
    public function store(Request $request)
    {
        $user = $request->user();
        $client = $user->client;
        
        if (!$client) {
            abort(404, 'Клиент не найден');
        }
        
        $validated = $request->validate([
            'credit_type_id' => 'required|exists:credit_type,id',
            'amount' => 'required|numeric|min:1000|max:10000000',
            'term' => 'required|integer|min:1|max:360',
        ]);
        
        $creditType = CreditTypeModel::find($validated['credit_type_id']);
        $baseRate = 15.0;
        
        $credit = CreditsModel::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'client_id' => $client->id,
            'credit_type_id' => $validated['credit_type_id'],
            'amount' => $validated['amount'],
            'rate' => $baseRate,
            'term' => $validated['term'],
            'start_date' => now(),
            'end_date' => now()->addMonths($validated['term']),
        ]);
        
        return redirect()->route('client.dashboard')
            ->with('success', 'Заявка на кредит успешно подана!');
    }
    
    public function show(string $creditId)
    {
        return $this->index($creditId);
    }
    
    public function history(string $clientId)
    {
        $credits = CreditRepository::getCredits($clientId);
        return view('credit-history', compact('credits'));
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $client = $user->client;
        
        if (!$client) {
            abort(404, 'Клиент не найден');
        }
        
        $creditTypes = CreditTypeModel::where('entity_type_id', $client->entity_type_id)
            ->get();
        
        return view('credits.create', compact('client', 'creditTypes'));
    }
}