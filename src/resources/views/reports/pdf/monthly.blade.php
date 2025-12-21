<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data['title'] }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { color: #333; text-align: center; }
        .header { text-align: center; margin-bottom: 30px; }
        .period { text-align: center; margin-bottom: 20px; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .summary { margin-top: 30px; padding: 15px; background-color: #f9f9f9; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $data['title'] }}</h1>
        <p>Дата формирования: {{ now()->format('d.m.Y H:i:s') }}</p>
    </div>
    
    @if(isset($data['period']))
        <div class="period">
            <p><strong>Период:</strong> {{ $data['period'] }}</p>
        </div>
    @endif
    
    @if(isset($data['data']) && $data['data']->count() > 0)
        <table>
            <thead>
                <tr>
                    @if($data['user_role'] === 'client')
                        <th>Тип кредита</th>
                        <th>Сумма</th>
                        <th>Ставка</th>
                        <th>Срок</th>
                        <th>Дата начала</th>
                        <th>Статус</th>
                    @else
                        <th>Клиент</th>
                        <th>Тип кредита</th>
                        <th>Сумма</th>
                        <th>Ставка</th>
                        <th>Срок</th>
                        <th>Дата начала</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($data['data'] as $credit)
                <tr>
                    @if($data['user_role'] === 'client')
                        <td>{{ $credit->creditType->name ?? 'N/A' }}</td>
                        <td>{{ number_format($credit->amount, 2) }} ₽</td>
                        <td>{{ $credit->rate }}%</td>
                        <td>{{ $credit->term }} мес.</td>
                        <td>{{ $credit->start_date->format('d.m.Y') }}</td>
                        <td>{{ $credit->end_date && $credit->end_date->isPast() ? 'Завершен' : 'Активен' }}</td>
                    @else
                        <td>{{ $credit->client->fullname ?? 'N/A' }}</td>
                        <td>{{ $credit->creditType->name ?? 'N/A' }}</td>
                        <td>{{ number_format($credit->amount, 2) }} ₽</td>
                        <td>{{ $credit->rate }}%</td>
                        <td>{{ $credit->term }} мес.</td>
                        <td>{{ $credit->start_date->format('d.m.Y') }}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    @if(isset($data['summary']))
        <div class="summary">
            <h3>Итоги:</h3>
            <ul>
                @foreach($data['summary'] as $key => $value)
                <li><strong>{{ $key }}:</strong> 
                    @if(str_contains($key, 'amount') || str_contains($key, 'rate'))
                        @if(is_numeric($value))
                            {{ number_format($value, 2) }}
                            {{ str_contains($key, 'rate') ? '%' : '₽' }}
                        @else
                            {{ $value }}
                        @endif
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