<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data['title'] }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { color: #333; text-align: center; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .summary { margin-top: 30px; padding: 15px; background-color: #f9f9f9; }
        .month-name { text-transform: capitalize; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $data['title'] }}</h1>
        <p>Год: {{ $data['year'] }}</p>
        <p>Дата формирования: {{ now()->format('d.m.Y H:i:s') }}</p>
    </div>
    
    @if(isset($data['monthly_data']))
        <table>
            <thead>
                <tr>
                    <th>Месяц</th>
                    <th>Кол-во платежей</th>
                    <th>Сумма платежей</th>
                    <th>Средний платеж</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $monthNames = [
                        1 => 'Январь', 2 => 'Февраль', 3 => 'Март',
                        4 => 'Апрель', 5 => 'Май', 6 => 'Июнь',
                        7 => 'Июль', 8 => 'Август', 9 => 'Сентябрь',
                        10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь'
                    ];
                @endphp
                @foreach($data['monthly_data'] as $month => $monthData)
                <tr>
                    <td class="month-name">{{ $monthNames[$month] ?? $month }}</td>
                    <td>{{ $monthData['payments_count'] }}</td>
                    <td>{{ number_format($monthData['payments_amount'], 2) }} ₽</td>
                    <td>
                        @if($monthData['payments_count'] > 0)
                            {{ number_format($monthData['payments_amount'] / $monthData['payments_count'], 2) }} ₽
                        @else
                            0 ₽
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    <div class="summary">
        <h3>Итоги за год:</h3>
        <ul>
            <li><strong>Общая сумма платежей:</strong> {{ number_format($data['total_payments'], 2) }} ₽</li>
            <li><strong>Средний месячный платеж:</strong> {{ number_format($data['avg_monthly_payment'], 2) }} ₽</li>
        </ul>
    </div>
</body>
</html>