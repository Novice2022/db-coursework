<?php

namespace App\Http\Controllers;

use App\Models\ClientsModel;
use App\Models\CreditsModel;
use App\Models\CreditTypeModel;
use App\Models\EntityTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'totalClients' => ClientsModel::count(),
            'totalCredits' => CreditsModel::count(),
            'totalAmount' => CreditsModel::sum('amount'),
            'activeCredits' => CreditsModel::where('end_date', '>', now())->count(),
        ];
        
        $recentCredits = CreditsModel::with(['client', 'creditType'])
            ->orderBy('start_date', 'desc')
            ->limit(10)
            ->get();
            
        return view('manager.dashboard', compact('stats', 'recentCredits'));
    }
    
    public function clients()
    {
        $clients = ClientsModel::with(['entityType', 'credits'])
            ->orderBy('registration_date', 'desc')
            ->paginate(20);
            
        return view('manager.clients', compact('clients'));
    }
    
    public function clientDetails($id)
    {
        $client = ClientsModel::with(['entityType', 'credits' => function($query) {
            $query->with(['creditType', 'payments', 'fines']);
        }])->findOrFail($id);
        
        return view('manager.client-details', compact('client'));
    }
    
    public function credits()
    {
        $credits = CreditsModel::with(['client', 'creditType', 'payments', 'fines'])
            ->orderBy('start_date', 'desc')
            ->paginate(20);
            
        return view('manager.credits', compact('credits'));
    }
    
    public function createCredit()
    {
        $clients = ClientsModel::all();
        $creditTypes = CreditTypeModel::all();
        
        return view('manager.create-credit', compact('clients', 'creditTypes'));
    }
    
    public function creditDetails($id)
    {
        $credit = CreditsModel::with(['client', 'creditType', 'payments', 'fines'])
            ->findOrFail($id);
            
        return view('manager.credit-details', compact('credit'));
    }
    
    public function reports()
    {
        return view('manager.reports');
    }
    
    public function clientsReport()
    {
        $clients = ClientsModel::with(['entityType', 'credits'])
            ->orderBy('registration_date', 'desc')
            ->get();
            
        return view('manager.reports.clients', compact('clients'));
    }
    
    public function financialReport()
    {
        $financialData = CreditsModel::selectRaw('
            DATE_FORMAT(start_date, "%Y-%m") as month,
            COUNT(*) as count,
            SUM(amount) as total_amount,
            AVG(rate) as avg_rate
        ')
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();
        
        return view('manager.reports.financial', compact('financialData'));
    }

    public function storeCredit(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'credit_type_id' => 'required|exists:credit_type,id',
            'amount' => 'required|numeric|min:1000',
            'rate' => 'required|numeric|min:1|max:50',
            'term' => 'required|integer|min:1|max:120',
        ]);
        
        // Преобразуем term в integer
        $term = (int) $request->term;
        
        $credit = CreditsModel::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'client_id' => $request->client_id,
            'credit_type_id' => $request->credit_type_id,
            'amount' => $request->amount,
            'rate' => $request->rate,
            'term' => $term,
            'start_date' => now(),
            'end_date' => now()->addMonths($term), // Теперь term точно integer
        ]);
        
        return redirect()->route('manager.credits.show', $credit->id)
            ->with('success', 'Кредит успешно создан');
    }
}