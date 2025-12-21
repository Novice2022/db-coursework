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
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $data['title'] }}</h1>
        <p>Дата формирования: {{ $data['date'] }}</p>
    </div>
    
    @if(isset($data['clients']) && $data['clients']->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Телефон</th>
                    <th>Тип клиента</th>
                    <th>Дата регистрации</th>
                    <th>Кол-во кредитов</th>
                    <th>Общая сумма</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['clients'] as $client)
                <tr>
                    <td>{{ $client->fullname }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->entityType->name ?? 'N/A' }}</td>
                    <td>{{ $client->registration_date->format('d.m.Y') }}</td>
                    <td>{{ $client->credits->count() }}</td>
                    <td>{{ number_format($client->credits->sum('amount'), 2) }} ₽</td>
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
                <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>