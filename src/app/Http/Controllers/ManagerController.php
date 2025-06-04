<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Client;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function applications()
    {
        $applications = Credit::where('start_date', '>=', now()->subDays(7))
            ->whereNull('end_date')
            ->with(['client', 'creditType'])
            ->get();

        return view('manager.applications', compact('applications'));
    }

    public function clients()
    {
        $clients = Client::with(['credits', 'user'])
            ->orderBy('registration_date', 'desc')
            ->paginate(20);

        return view('manager.clients', compact('clients'));
    }

    public function showApplication(Credit $application)
    {
        $application->load(['client', 'creditType', 'client.individualEntity', 'client.legalEntity']);
        
        return view('manager.applications.show', compact('application'));
    }

    public function approve(Request $request, Credit $application)
    {
        $application->update([
            'start_date' => now(),
            'rate' => $request->input('final_rate', $application->rate)
        ]);

        return redirect()->route('manager.applications')
            ->with('success', 'Заявка одобрена');
    }

    public function reject(Request $request, Credit $application)
    {
        $application->update([
            'end_date' => now(),
            'amount' => 0
        ]);

        return redirect()->route('manager.applications')
            ->with('success', 'Заявка отклонена');
    }
}