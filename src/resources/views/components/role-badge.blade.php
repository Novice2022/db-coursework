@php
    $config = [
        1 => ['class' => 'badge-primary', 'text' => 'Клиент'],
        2 => ['class' => 'badge-success', 'text' => 'Менеджер'],
        3 => ['class' => 'badge-warning', 'text' => 'Аналитик'],
        4 => ['class' => 'badge-danger', 'text' => 'Администратор'],
    ][$roleId] ?? ['class' => 'badge-secondary', 'text' => 'Неизвестно'];
@endphp

<span class="badge {{ $config['class'] }}">{{ $config['text'] }}</span>