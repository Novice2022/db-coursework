<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $payments = Payment::whereHas('credit', function($query) use ($user) {
                $query->where('client_id', $user->client_id);
            })
            ->with('credit')
            ->orderBy('datetime', 'desc')
            ->get();

        return view('payments.index', compact('payments'));
    }

    public function store(Request $request, Credit $credit)
    {
        if ($credit->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $payment = new Payment();
        $payment->id = \Illuminate\Support\Str::uuid();
        $payment->credit_id = $credit->id;
        $payment->amount = $validated['amount'];
        $payment->save();

        // Проверяем и обновляем статус кредита, если он полностью погашен
        $this->checkCreditCompletion($credit);

        return redirect()->route('credits.show', $credit->id)
            ->with('success', 'Платеж успешно проведен');
    }

    private function checkCreditCompletion(Credit $credit)
    {
        $totalPaid = $credit->payments()->sum('amount');
        if ($totalPaid >= $credit->amount) {
            $credit->end_date = now();
            $credit->save();
        }
    }
}