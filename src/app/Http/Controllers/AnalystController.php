<?php

namespace App\Http\Controllers;

use App\Models\CreditsModel;
use App\Models\ClientsModel;
use App\Models\PaymentsModel;
use App\Models\FinesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalystController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'totalDebt' => CreditsModel::where('end_date', '>', now())->sum('amount'),
            'overdueCredits' => CreditsModel::where('end_date', '<', now())->count(),
            'totalFines' => FinesModel::whereNull('payed_at')->sum('amount'),
            'avgRate' => CreditsModel::avg('rate'),
        ];
        
        // Исправляем запрос для PostgreSQL
        $riskDistribution = CreditsModel::selectRaw('
            CASE 
                WHEN end_date < NOW() THEN \'Просрочен\'
                WHEN EXTRACT(DAY FROM (end_date - NOW())) < 30 THEN \'Высокий риск\'
                WHEN EXTRACT(DAY FROM (end_date - NOW())) < 90 THEN \'Средний риск\'
                ELSE \'Низкий риск\'
            END as risk_level,
            COUNT(*) as count,
            SUM(amount) as total_amount
        ')
        ->groupBy('risk_level')
        ->get();
        
        return view('analyst.dashboard', compact('stats', 'riskDistribution'));
    }
    
    public function riskAnalysis()
    {
        $riskyCredits = CreditsModel::with(['client', 'payments', 'fines'])
            ->where('end_date', '<', now()->addDays(30))
            ->orderBy('end_date')
            ->paginate(20);
            
        return view('analyst.risk', compact('riskyCredits'));
    }
    
    public function reports()
    {
        return view('analyst.reports');
    }
    
    public function riskReport()
    {
        $riskData = CreditsModel::with('client')
            ->select('*', 
                DB::raw('EXTRACT(DAY FROM (end_date - NOW())) as days_left')
            )
            ->orderBy('days_left')
            ->get();
            
        return view('analyst.reports.risk', compact('riskData'));
    }
    
    public function export()
    {
        return view('analyst.export');
    }
    
    public function exportCredits()
    {
        $credits = CreditsModel::with(['client', 'creditType'])
            ->orderBy('start_date', 'desc')
            ->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="credits_' . date('Y-m-d') . '.csv"',
        ];
        
        $callback = function() use ($credits) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID кредита',
                'Клиент',
                'Тип клиента',
                'Тип кредита',
                'Сумма',
                'Ставка %',
                'Срок (мес)',
                'Дата выдачи',
                'Дата погашения',
                'Статус'
            ]);
            
            foreach ($credits as $credit) {
                $status = $credit->end_date > now() ? 'Активен' : 'Завершен';
                
                fputcsv($file, [
                    $credit->id,
                    $credit->client->fullname,
                    $credit->client->entityType->name,
                    $credit->creditType->name,
                    $credit->amount,
                    $credit->rate,
                    $credit->term,
                    $credit->start_date->format('d.m.Y'),
                    $credit->end_date ? $credit->end_date->format('d.m.Y') : '',
                    $status
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    public function exportPayments()
    {
        $payments = PaymentsModel::with(['credit.client'])
            ->orderBy('datetime', 'desc')
            ->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="payments_' . date('Y-m-d') . '.csv"',
        ];
        
        $callback = function() use ($payments) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID платежа',
                'Клиент',
                'ID кредита',
                'Сумма платежа',
                'Дата платежа',
                'Тип'
            ]);
            
            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->credit->client->fullname,
                    $payment->credit_id,
                    $payment->amount,
                    $payment->datetime->format('d.m.Y H:i'),
                    'Оплата'
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}