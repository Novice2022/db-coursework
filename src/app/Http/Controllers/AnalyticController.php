<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class AnalyticController extends Controller
{
    public function risks()
    {
        // Кредиты с просрочками платежей
        $riskyCredits = Credit::whereDoesntHave('payments', function($query) {
                $query->where('datetime', '>=', now()->subMonth());
            })
            ->where('end_date', null)
            ->with(['client', 'payments'])
            ->get();

        // Анализ платежеспособности клиентов
        $clientsAnalysis = Client::with(['credits', 'payments'])
            ->get()
            ->map(function($client) {
                $totalDebt = $client->credits->sum('amount');
                $totalPaid = $client->payments->sum('amount');
                $paymentRatio = $totalDebt > 0 ? ($totalPaid / $totalDebt) * 100 : 100;
                
                return [
                    'client' => $client,
                    'total_debt' => $totalDebt,
                    'total_paid' => $totalPaid,
                    'payment_ratio' => $paymentRatio,
                    'risk_level' => $this->calculateRiskLevel($paymentRatio)
                ];
            });

        return view('analytics.risks', compact('riskyCredits', 'clientsAnalysis'));
    }

    public function reports()
    {
        // Отчет по выданным кредитам
        $creditsReport = Credit::select(
                DB::raw('credit_type_id, count(*) as count, sum(amount) as total_amount')
            )
            ->groupBy('credit_type_id')
            ->with('creditType')
            ->get();

        // Отчет по платежам
        $paymentsReport = Payment::select(
                DB::raw('date(datetime) as date, sum(amount) as total_amount, count(*) as count')
            )
            ->where('datetime', '>=', now()->subYear())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('analytics.reports', compact('creditsReport', 'paymentsReport'));
    }

    private function calculateRiskLevel($paymentRatio)
    {
        if ($paymentRatio >= 90) return 'Низкий';
        if ($paymentRatio >= 70) return 'Средний';
        return 'Высокий';
    }
}