<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Credit;
use App\Models\CreditType;

class CreditController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $credits = Credit::where('client_id', $user->client_id)
            ->with('creditType')
            ->get();

        return view('credits.index', compact('credits'));
    }

    public function create()
    {
        $client = Client::findOrFail(Auth::user()->client_id);
        $creditTypes = CreditType::where('entity_type_id', $client->entity_type_id)->get();
        
        return view('credits.create', compact('creditTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'credit_type_id' => 'required|exists:credit_type,id',
            'amount' => 'required|numeric|min:1000',
            'term' => 'required|integer|min:1|max:60',
        ]);

        $client = Client::findOrFail(Auth::user()->client_id);
        
        $credit = new Credit();
        $credit->id = \Illuminate\Support\Str::uuid();
        $credit->client_id = $client->id;
        $credit->credit_type_id = $validated['credit_type_id'];
        $credit->amount = $validated['amount'];
        $credit->term = $validated['term'];
        
        // Рассчитываем ставку на основе типа клиента и других факторов
        $credit->rate = $this->calculateInterestRate($client, $validated['credit_type_id']);
        
        $credit->save();

        return redirect()->route('credits.show', $credit->id)
            ->with('success', 'Кредитная заявка успешно создана');
    }

    public function show(Credit $credit)
    {
        if ($credit->client_id !== Auth::user()->client_id) {
            abort(403);
        }

        $credit->load(['payments', 'fines', 'creditType']);
        
        return view('credits.show', compact('credit'));
    }

    private function calculateInterestRate(Client $client, $creditTypeId)
    {
        $baseRate = 10.0; // Базовая ставка
        
        // Дополнительные надбавки в зависимости от типа клиента
        if ($client->entity_type_id == 1) { // Физическое лицо
            $individual = $client->individualEntity;
            $historySupplement = $individual->creditHistory->supplement ?? 0;
            $baseRate += $historySupplement;
        } else { // Юридическое лицо
            $legal = $client->legalEntity;
            $industrySupplement = $legal->industry->supplement ?? 0;
            $profitabilitySupplement = $legal->profitability->supplement ?? 0;
            $baseRate += ($industrySupplement + $profitabilitySupplement);
        }
        
        return $baseRate;
    }
}
