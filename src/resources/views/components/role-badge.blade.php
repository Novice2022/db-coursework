@props(['roleId'])

@php
    $config = match($roleId) {
        1 => ['color' => 'bg-blue-100 text-blue-800', 'text' => 'Клиент'],
        2 => ['color' => 'bg-green-100 text-green-800', 'text' => 'Менеджер'],
        3 => ['color' => 'bg-purple-100 text-purple-800', 'text' => 'Аналитик'],
        4 => ['color' => 'bg-red-100 text-red-800', 'text' => 'Администратор'],
        default => ['color' => 'bg-gray-100 text-gray-800', 'text' => 'Неизвестно'],
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {$config['color']}"]) }}>
    {{ $config['text'] }}
</span>