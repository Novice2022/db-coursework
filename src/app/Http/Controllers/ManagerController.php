<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientsModel;
use App\Models\CreditsModel;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_clients' => ClientsModel::count(),
            'active_credits' => CreditsModel::where('end_date', '>', now())->count(),
            'total_amount' => CreditsModel::sum('amount'),
            'avg_rate' => CreditsModel::avg('rate'),
            'new_clients_today' => ClientsModel::whereDate('registration_date', today())->count(),
        ];
        
        $recentClients = ClientsModel::with(['entityType'])
            ->orderBy('registration_date', 'desc')
            ->take(5)
            ->get();
            
        $recentCredits = CreditsModel::with(['client', 'creditType'])
            ->orderBy('start_date', 'desc')
            ->take(5)
            ->get();
        
        return view('manager.dashboard', compact('stats', 'recentClients', 'recentCredits'));
    }
    
    public function clients(Request $request)
    {
        $query = ClientsModel::with(['entityType', 'credits'])
            ->orderBy('registration_date', 'desc');
            
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('fullname', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('entity_type')) {
            $query->where('entity_type_id', $request->get('entity_type'));
        }
        
        $clients = $query->paginate(15);
        
        return view('manager.clients', compact('clients'));
    }
    
    public function showClient($clientId)
    {
        $client = ClientsModel::with([
            'entityType',
            'credits' => function($query) {
                $query->with(['creditType', 'payments', 'fines'])
                     ->orderBy('start_date', 'desc');
            },
            'legalEntity.industry',
            'legalEntity.profitability',
            'individualEntity.creditHistory',
        ])->findOrFail($clientId);
        
        $stats = [
            'total_credits' => $client->credits->count(),
            'active_credits' => $client->credits->where('end_date', '>', now())->count(),
            'total_borrowed' => $client->credits->sum('amount'),
            'total_paid' => $client->credits->reduce(function($carry, $credit) {
                return $carry + $credit->payments->sum('amount');
            }, 0),
        ];
        
        return view('manager.client-show', compact('client', 'stats'));
    }
    
    public function updateClient(Request $request, $clientId)
    {
        $client = ClientsModel::findOrFail($clientId);
        
        $validated = $request->validate([
            'fullname' => 'required|string|max:100',
            'phone' => 'required|string|max:20|unique:clients,phone,' . $client->id,
            'address' => 'nullable|string|max:255',
        ]);
        
        $client->update($validated);
        
        return redirect()->route('manager.clients.show', $clientId)
            ->with('success', 'Данные клиента обновлены');
    }
    
    public function createCreditForClient(Request $request, $clientId)
    {
        $client = ClientsModel::findOrFail($clientId);
        
        $validated = $request->validate([
            'credit_type_id' => 'required|exists:credit_type,id',
            'amount' => 'required|numeric|min:1000|max:10000000',
            'rate' => 'required|numeric|min:1|max:50',
            'term' => 'required|integer|min:1|max:360',
            'start_date' => 'required|date',
        ]);
        
        $validated['client_id'] = $client->id;
        $validated['id'] = \Illuminate\Support\Str::uuid();
        
        $credit = CreditsModel::create($validated);
        
        return redirect()->route('manager.clients.show', $clientId)
            ->with('success', 'Кредит успешно создан');
    }
    
    public function credits(Request $request)
    {
        $query = CreditsModel::with(['client', 'creditType'])
            ->orderBy('start_date', 'desc');
            
        if ($request->has('status')) {
            $status = $request->get('status');
            if ($status === 'active') {
                $query->where('end_date', '>', now());
            } elseif ($status === 'completed') {
                $query->where('end_date', '<=', now());
            }
        }
        
        if ($request->has('client_id')) {
            $query->where('client_id', $request->get('client_id'));
        }
        
        $credits = $query->paginate(15);
        
        return view('manager.credits', compact('credits'));
    }
    
    public function analytics()
    {
        $monthlyStats = CreditsModel::select(
                DB::raw('EXTRACT(YEAR FROM start_date) as year'),
                DB::raw('EXTRACT(MONTH FROM start_date) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('AVG(rate) as avg_rate')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();
            
        $creditTypeDistribution = CreditsModel::select(
                'credit_type.name',
                DB::raw('COUNT(credits.id) as count'),
                DB::raw('SUM(credits.amount) as total_amount')
            )
            ->join('credit_type', 'credits.credit_type_id', '=', 'credit_type.id')
            ->groupBy('credit_type.id', 'credit_type.name')
            ->get();
            
        return view('manager.analytics', compact('monthlyStats', 'creditTypeDistribution'));
    }
    
    public function applications()
    {
        return view('manager.applications');
    }
}