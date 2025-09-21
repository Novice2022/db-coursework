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
            'monthlyPayment' => self::_getMonthlyPayment($credit, $payments),
        ];

        return $result;
    }

    private static function _getCreditAmountRemains(
        CreditsModel $credit,
        $payments
    ): float {
        $amount = $credit -> amount;

        foreach ($payments as $payment) {
            $amount -= $payment -> amount;
            $amount *= 1 + $credit -> rate / 100;
        }

        return $amount;
    }

    private static function _getMonthlyPayment(
        CreditsModel $credit,
        $payments
    ): float {
        $amount = $credit -> amount;
        $term = $credit -> term;
        $rate = $credit -> rate;

        $paymentsAmount = 0;

        foreach ($payments as $payment) {
            $paymentsAmount += $payment -> amount;
        }

        $amount -= $paymentsAmount;
        $term -= $payment -> count();
        $monthRate = $rate / 12;
        
        $annuityRatio =
            (($monthRate * (1 + $monthRate)) ** $term) /
            ((1 + $monthRate) ** $term - 1);

        return $amount * $annuityRatio;
    }
}
