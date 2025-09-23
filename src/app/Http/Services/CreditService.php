<?php

namespace App\Http\Services;

use App\Models\CreditsModel;

class CreditService {
    public static function calculateCreditRemains(
        CreditsModel $credit,
        $payments
    ): array {
        $result = [
            'creditAmountRemains' => self::_getCreditAmountRemains($credit, $payments),
            'monthlyPayment' => self::_getMonthlyPayment($credit)
        ];

        return $result;
    }

    private static function _getCreditAmountRemains(
        CreditsModel $credit,
        $payments
    ): float {
        $monthRate = $credit -> rate / 12;
        $amount = $credit -> amount;

        foreach ($payments as $payment) {
            $amount -= $payment -> amount;
            $amount *= 1 + $monthRate / 100;
        }

        return round($amount, 2);
    }

    private static function _getMonthlyPayment(
        CreditsModel $credit
    ): float {
        $amount = $credit -> amount;
        $term = $credit -> term;
        $monthRate = $credit -> rate / 1_200;

        return round(
            ($amount * $monthRate * ((1 + $monthRate) ** $term)) /
                (((1 + $monthRate) ** $term) - 1),
            2
        );
    }
}
