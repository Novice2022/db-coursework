<?php

namespace App\Http\Repositories;

use App\Models\CreditsModel;
use App\Models\PaymentsModel;
use App\Models\FinesModel;

class CreditRepository
{
    public static function getCredit(string $creditId)
    {
        $credit = CreditsModel::with('creditType')->find($creditId);
        
        if (!$credit) {
            return null;
        }
        
        return [
            'id' => $credit->id,
            'name' => $credit->creditType->name,
            'amount' => $credit->amount,
            'rate' => $credit->rate,
            'term' => $credit->term,
            'start_date' => $credit->start_date,
        ];
    }
    
    public static function getCredits(string $clientId)
    {
        return CreditsModel::where('client_id', $clientId)
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
    }
    
    public static function getCreditPayments(string $creditId)
    {
        return PaymentsModel::where('credit_id', $creditId)
            ->orderBy('datetime', 'asc')
            ->get();
    }
    
    public static function getCreditFines(string $creditId)
    {
        return FinesModel::where('credit_id', $creditId)
            ->orderBy('datetime', 'asc')
            ->get()
            ->map(function($fine) {
                return [
                    'id' => $fine->id,
                    'amount' => $fine->amount,
                    'reason' => $fine->reason,
                    'datetime' => $fine->datetime->format('Y-m-d H:i:s'),
                    'payed_at' => $fine->payed_at ? $fine->payed_at->format('Y-m-d H:i:s') : null,
                ];
            });
    }
}