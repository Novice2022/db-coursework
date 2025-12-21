<x-app-layout>
    <div class="dashboard-container">
        <!-- Приветствие -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold">
                Добро пожаловать, {{ auth()->user()->name }}!
            </h1>
            <p class="text-gray-600 mt-2">
                {{ now()->format('d.m.Y') }}
            </p>
        </div>

        <!-- Контент в зависимости от роли -->
        @if(auth()->user()->isClient())
            @include('dashboard.client')
        @elseif(auth()->user()->isManager())
            @include('dashboard.manager')
        @elseif(auth()->user()->isAnalyst())
            @include('dashboard.analyst')
        @elseif(auth()->user()->isAdmin())
            @include('dashboard.admin')
        @else
            <div class="bg-white rounded-lg shadow p-6">
                <p>Добро пожаловать в систему!</p>
            </div>
        @endif
    </div>
</x-app-layout>