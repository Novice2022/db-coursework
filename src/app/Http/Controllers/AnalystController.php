<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditsModel;
use App\Models\FinesModel;
use App\Models\ClientsModel;
use App\Models\PaymentsModel;
use Illuminate\Support\Facades\DB;

class AnalystController extends Controller
{
    public function dashboard()
    {
        $totalCredits = CreditsModel::count();
        
        $overdueCredits = CreditsModel::where('end_date', '<', now())
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('payments')
                    ->whereColumn('payments.credit_id', 'credits.id')
                    ->groupBy('payments.credit_id')
                    ->havingRaw('SUM(payments.amount) < credits.amount');
            })
            ->count();
        
        $totalFines = FinesModel::whereNull('payed_at')->sum('amount');
        
        $highRiskClients = ClientsModel::whereHas('credits', function($query) {
            $query->where('rate', '>', 20);
        })->count();
        
        $stats = [
            'total_risky_clients' => $highRiskClients,
            'overdue_credits' => $overdueCredits,
            'total_fines' => $totalFines,
            'total_credits' => $totalCredits,
        ];
        
        return view('analyst.dashboard', compact('stats'));
    }
    
    public function riskAssessment(Request $request)
    {
        $clients = ClientsModel::with(['entityType', 'credits', 'credits.payments', 'credits.fines'])
            ->orderBy('registration_date', 'desc')
            ->paginate(20);
        
        $clients->getCollection()->transform(function ($client) {
            $client->risk_score = $this->calculateRiskScore($client);
            $client->risk_level = $this->getRiskLevel($client->risk_score);
            return $client;
        });
            
        return view('analyst.risk-assessment', compact('clients'));
    }
    
    public function overdueCredits()
    {
        $overdueCredits = CreditsModel::with(['client', 'creditType', 'payments'])
            ->where('end_date', '<', now())
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('payments')
                    ->whereColumn('payments.credit_id', 'credits.id')
                    ->groupBy('payments.credit_id')
                    ->havingRaw('SUM(payments.amount) < credits.amount');
            })
            ->get()
            ->map(function($credit) {
                $paid = $credit->payments->sum('amount');
                $remaining = $credit->amount - $paid;
                $overdueDays = now()->diffInDays($credit->end_date);
                
                return [
                    'credit' => $credit,
                    'remaining' => $remaining,
                    'overdue_days' => $overdueDays,
                ];
            });
        
        return view('analyst.overdue-credits', compact('overdueCredits'));
    }
    
    public function generateReport(Request $request)
    {
        $type = $request->get('type', 'risk');
        
        switch ($type) {
            case 'risk':
                $data = $this->generateRiskReport();
                break;
            case 'overdue':
                $data = $this->generateOverdueReport();
                break;
            case 'financial':
                $data = $this->generateFinancialReport();
                break;
            default:
                $data = $this->generateRiskReport();
        }
        
        if ($request->get('format') === 'pdf') {
            return response()->streamDownload(function() use ($data, $type) {
                echo view('reports.pdf.' . $type, compact('data'))->render();
            }, 'report_' . $type . '_' . now()->format('Y_m_d') . '.pdf');
        }
        
        return view('analyst.report', compact('data', 'type'));
    }
    
    private function calculateRiskScore($client)
    {
        $score = 50;
        
        if ($client->credits->count() > 3) $score += 10;
        if ($client->credits->where('rate', '>', 15)->count() > 0) $score += 15;
        
        if ($client->entity_type_id == 1 && $client->individualEntity) {
            if ($client->individualEntity->income < 50000) $score += 10;
            if ($client->individualEntity->credit_history_quality === 'poor') $score += 20;
        }
        
        if ($client->entity_type_id == 2 && $client->legalEntity) {
            if ($client->legalEntity->profitability === 'low') $score += 15;
        }
        
        return min($score, 100);
    }
    
    private function getRiskLevel($score)
    {
        if ($score <= 30) return 'Низкий';
        if ($score <= 60) return 'Средний';
        if ($score <= 80) return 'Высокий';
        return 'Критический';
    }
    
    private function generateRiskReport()
    {
        $clients = ClientsModel::with(['entityType', 'credits'])->get();
        
        $clients->transform(function ($client) {
            $client->risk_score = $this->calculateRiskScore($client);
            $client->risk_level = $this->getRiskLevel($client->risk_score);
            return $client;
        });
        
        return [
            'title' => 'Отчет по оценке рисков',
            'clients' => $clients,
            'date' => now()->format('d.m.Y H:i:s'),
            'statistics' => [
                'Всего клиентов' => $clients->count(),
                'Клиентов с высоким риском' => $clients->where('risk_score', '>', 60)->count(),
                'Клиентов с критическим риском' => $clients->where('risk_score', '>', 80)->count(),
                'Средний уровень риска' => round($clients->avg('risk_score'), 2),
            ]
        ];
    }
    
    private function generateOverdueReport()
    {
        $overdueCredits = CreditsModel::with(['client', 'creditType', 'payments'])
            ->where('end_date', '<', now())
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('payments')
                    ->whereColumn('payments.credit_id', 'credits.id')
                    ->groupBy('payments.credit_id')
                    ->havingRaw('SUM(payments.amount) < credits.amount');
            })
            ->get();
        
        return [
            'title' => 'Отчет по просроченным кредитам',
            'credits' => $overdueCredits,
            'date' => now()->format('d.m.Y H:i:s'),
            'statistics' => [
                'Всего просроченных кредитов' => $overdueCredits->count(),
                'Общая сумма просрочки' => $overdueCredits->sum('amount'),
                'Средний срок просрочки (дней)' => round($overdueCredits->avg(function($credit) {
                    return now()->diffInDays($credit->end_date);
                }), 2),
            ]
        ];
    }
    
    private function generateFinancialReport()
    {
        $year = now()->year;
        
        $monthlyData = PaymentsModel::select(
                DB::raw('EXTRACT(MONTH FROM datetime) as month'),
                DB::raw('COUNT(*) as payments_count'),
                DB::raw('SUM(amount) as payments_amount')
            )
            ->whereYear('datetime', $year)
            ->groupBy(DB::raw('EXTRACT(MONTH FROM datetime)'))
            ->orderBy('month')
            ->get()
            ->keyBy('month');
        
        $totalPayments = PaymentsModel::whereYear('datetime', $year)->sum('amount');
        
        return [
            'title' => 'Финансовый отчет за ' . $year . ' год',
            'year' => $year,
            'monthly_data' => $monthlyData,
            'total_payments' => $totalPayments,
            'avg_monthly_payment' => $totalPayments / 12,
        ];
    }
}