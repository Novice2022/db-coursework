// src/app/Http/Controllers/ReportController.php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CreditsModel;
use App\Models\ClientsModel;
use App\Models\FinesModel;
use App\Models\PaymentsModel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            'auth',
        ];
    }
    
    public function generateReport(Request $request)
    {
        $user = $request->user();
        $type = $request->get('type', 'credits');
        $format = $request->get('format', 'html');
        
        switch ($type) {
            case 'credits':
                $data = $this->generateCreditsReport($user);
                break;
            case 'clients':
                $data = $this->generateClientsReport($user);
                break;
            case 'financial':
                $data = $this->generateFinancialReport($user);
                break;
            case 'fines':
                $data = $this->generateFinesReport($user);
                break;
            default:
                $data = $this->generateCreditsReport($user);
        }
        
        if ($format === 'pdf') {
            return $this->downloadPdf($data, $type);
        } elseif ($format === 'excel') {
            return $this->downloadExcel($data, $type);
        }
        
        return view('reports.show', compact('data', 'type'));
    }
    
    public function downloadReport($type)
    {
        $user = Auth::user();
        
        switch ($type) {
            case 'credits':
                $data = $this->generateCreditsReport($user);
                break;
            case 'clients':
                $data = $this->generateClientsReport($user);
                break;
            default:
                abort(404);
        }
        
        return $this->downloadPdf($data, $type);
    }
    
    private function generateCreditsReport($user)
    {
        if ($user->isClient()) {
            $credits = CreditsModel::where('client_id', $user->client_id)
                ->with('creditType')
                ->get();
        } else {
            $credits = CreditsModel::with(['client', 'creditType'])
                ->orderBy('start_date', 'desc')
                ->get();
        }
        
        return [
            'title' => 'Отчет по кредитам',
            'credits' => $credits,
            'date' => now()->format('d.m.Y H:i:s'),
            'user_role' => $user->role_id,
            'statistics' => [
                'Всего кредитов' => $credits->count(),
                'Общая сумма' => number_format($credits->sum('amount'), 2) . ' ₽',
                'Средняя ставка' => round($credits->avg('rate'), 2) . '%',
                'Средний срок' => round($credits->avg('term'), 0) . ' мес.',
            ]
        ];
    }
    
    private function generateClientsReport($user)
    {
        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }
        
        $clients = ClientsModel::with(['entityType', 'credits'])
            ->orderBy('registration_date', 'desc')
            ->get();
        
        return [
            'title' => 'Отчет по клиентам',
            'clients' => $clients,
            'date' => now()->format('d.m.Y H:i:s'),
            'statistics' => [
                'Всего клиентов' => $clients->count(),
                'Физические лица' => $clients->where('entity_type_id', 1)->count(),
                'Юридические лица' => $clients->where('entity_type_id', 2)->count(),
                'Клиенты с кредитами' => $clients->where('credits_count', '>', 0)->count(),
            ]
        ];
    }
    
    private function generateFinancialReport($user)
    {
        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }
        
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
    
    private function generateFinesReport($user)
    {
        if (!$user->isClient() && !$user->isManager() && !$user->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }
        
        if ($user->isClient()) {
            $fines = FinesModel::whereHas('credit', function($query) use ($user) {
                $query->where('client_id', $user->client_id);
            })->with('credit')->get();
        } else {
            $fines = FinesModel::with('credit')->get();
        }
        
        return [
            'title' => 'Отчет по штрафам',
            'fines' => $fines,
            'date' => now()->format('d.m.Y H:i:s'),
            'statistics' => [
                'Всего штрафов' => $fines->count(),
                'Оплаченные штрафы' => $fines->whereNotNull('payed_at')->count(),
                'Неоплаченные штрафы' => $fines->whereNull('payed_at')->count(),
                'Общая сумма штрафов' => number_format($fines->sum('amount'), 2) . ' ₽',
                'Сумма оплаченных' => number_format($fines->whereNotNull('payed_at')->sum('amount'), 2) . ' ₽',
                'Сумма неоплаченных' => number_format($fines->whereNull('payed_at')->sum('amount'), 2) . ' ₽',
            ]
        ];
    }
    
    private function downloadPdf($data, $type)
    {
        $pdf = Pdf::loadView('reports.pdf.' . $type, compact('data'));
        $filename = 'report_' . $type . '_' . now()->format('Y_m_d') . '.pdf';
        
        return $pdf->download($filename);
    }
    
    private function downloadExcel($data, $type)
    {
        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromArray {
            private $data;
            
            public function __construct($data)
            {
                $this->data = $data;
            }
            
            public function array(): array
            {
                $array = [];
                
                if (isset($this->data['credits'])) {
                    $array[] = ['ID', 'Клиент', 'Тип кредита', 'Сумма', 'Ставка', 'Срок', 'Дата начала'];
                    foreach ($this->data['credits'] as $credit) {
                        $array[] = [
                            $credit->id,
                            $credit->client->fullname ?? 'N/A',
                            $credit->creditType->name ?? 'N/A',
                            $credit->amount,
                            $credit->rate,
                            $credit->term,
                            $credit->start_date->format('d.m.Y'),
                        ];
                    }
                } elseif (isset($this->data['clients'])) {
                    $array[] = ['ФИО', 'Телефон', 'Тип клиента', 'Дата регистрации', 'Кол-во кредитов', 'Общая сумма'];
                    foreach ($this->data['clients'] as $client) {
                        $array[] = [
                            $client->fullname,
                            $client->phone,
                            $client->entityType->name ?? 'N/A',
                            $client->registration_date->format('d.m.Y'),
                            $client->credits->count(),
                            $client->credits->sum('amount'),
                        ];
                    }
                }
                
                return $array;
            }
        }, 'report_' . $type . '_' . now()->format('Y_m_d') . '.xlsx');
    }
}