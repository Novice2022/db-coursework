<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data['title'] }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { color: #333; text-align: center; }
        .header { text-align: center; margin-bottom: 30px; }
        .date { text-align: right; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .summary { margin-top: 30px; padding: 15px; background-color: #f9f9f9; }
        .paid { color: green; }
        .unpaid { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $data['title'] }}</h1>
        <p>Дата формирования: {{ $data['date'] }}</p>
    </div>
    
    @if(isset($data['fines']) && $data['fines']->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Клиент</th>
                    <th>Кредит</th>
                    <th>Причина</th>
                    <th>Сумма</th>
                    <th>Дата</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['fines'] as $fine)
                <tr>
                    <td>{{ $fine->credit->client->fullname ?? 'N/A' }}</td>
                    <td>{{ $fine->credit->creditType->name ?? 'N/A' }}</td>
                    <td>{{ $fine->reason }}</td>
                    <td>{{ number_format($fine->amount, 2) }} ₽</td>
                    <td>{{ $fine->datetime->format('d.m.Y H:i') }}</td>
                    <td class="{{ $fine->payed_at ? 'paid' : 'unpaid' }}">
                        {{ $fine->payed_at ? 'Оплачен' : 'Не оплачен' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    @if(isset($data['statistics']))
        <div class="summary">
            <h3>Статистика:</h3>
            <ul>
                @foreach($data['statistics'] as $key => $value)
                <li><strong>{{ $key }}:</strong> 
                    @if(str_contains($key, 'amount'))
                        {{ number_format($value, 2) }} ₽
                    @else
                        {{ $value }}
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>