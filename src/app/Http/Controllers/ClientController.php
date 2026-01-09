<?php

namespace App\Http\Controllers;

use App\Models\ClientsModel;
use App\Models\CreditsModel;
use App\Models\PaymentsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $client = $user->client;
        
        $credits = CreditsModel::where('client_id', $client->id)->get();
        $totalLoans = $credits->sum('amount');
        $activeLoans = $credits->where('end_date', '>', now())->count();
        
        return view('client.dashboard', [
            'client' => $client,
            'credits' => $credits,
            'totalLoans' => $totalLoans,
            'activeLoans' => $activeLoans,
        ]);
    }
    
    public function credits()
    {
        $client = Auth::user()->client;
        $credits = CreditsModel::with(['creditType', 'payments', 'fines'])
            ->where('client_id', $client->id)
            ->orderBy('start_date', 'desc')
            ->get();
            
        return view('client.credits', compact('credits'));
    }
    
    public function creditDetails($id)
    {
        $credit = CreditsModel::with(['creditType', 'payments', 'fines'])
            ->where('id', $id)
            ->where('client_id', Auth::user()->client->id)
            ->firstOrFail();
            
        return view('client.credit-details', compact('credit'));
    }
    
    public function payments()
    {
        $client = Auth::user()->client;
        $payments = PaymentsModel::with('credit')
            ->whereHas('credit', function($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->orderBy('datetime', 'desc')
            ->get();
            
        return view('client.payments', compact('payments'));
    }
    
    public function profile()
    {
        $client = Auth::user()->client->load(['entityType', 'legalEntity', 'individualEntity']);
        return view('client.profile', compact('client'));
    }
    
    public function updateProfile(Request $request)
    {
        $client = Auth::user()->client;
        
        $request->validate([
            'phone' => 'nullable|string|max:20|regex:/^[\d\s\-\+\(\)]+$/',
            'address' => 'nullable|string|max:255',
        ]);
        
        $client->update($request->only(['phone', 'address']));
        
        return redirect()->route('client.profile')
            ->with('success', 'Данные клиента успешно обновлены');
    }
}