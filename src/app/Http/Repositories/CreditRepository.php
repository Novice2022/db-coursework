<?php

namespace App\Http\Repositories;

use App\Models\CreditsModel;
use App\Models\FinesModel;
use App\Models\PaymentsModel;

class CreditRepository {
    public static function getCredits(string $clientId) {
        return CreditsModel::select(
            'credits.id as id',
            'name',
            'amount',
            'rate',
            'term',
            'start_date',
        )
            -> join('credit_type', 'credit_type_id', '=', 'credit_type.id')
            -> where('client_id', $clientId)
            -> get();
    }

    public static function getCredit(string $creditId) {
        // TODO: Доп. вычисленные данные по кредиту, например: сколько и как долго платить...
        
        $data = [];

        $data['info'] = CreditsModel::select(
            'credits.id as id',
            'name',
            'amount',
            'rate',
            'term',
            'start_date',
        )
            -> join('credit_type', 'credit_type_id', '=', 'credit_type.id')
            -> where('credits.id', $creditId)
            -> first();

        // $data['additional'] = ...

        return $data;
    }

    public static function getCreditPayments(string $creditId) {
        return PaymentsModel::select(
            'amount',
            'datetime'
        )
            -> where('credit_id', $creditId)
            -> get();
    }
    
    public static function getCreditFines(string $creditId) {
        return FinesModel::select(
            'id',
            'amount',
            'reason',
            'datetime',
            'payed_at'
        )
            -> where('credit_id', $creditId)
            -> get();
    }
}
