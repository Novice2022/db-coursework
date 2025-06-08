<x-app-layout>
    <div class="container py-4">
        @auth
            <!-- Дашборд для клиента -->
            @if(auth()->user()->role_id == 1)
                <div class="alert alert-light">
                    <h4>Панель клиента</h4>
                    @include('client.dashboard')
                </div>

            <!-- Дашборд для менеджера -->
            @elseif(auth()->user()->role_id == 2)
                <div class="alert alert-light">
                    <h4>Панель менеджера</h4>
                    <p class="mb-0">Здесь будет интерфейс для управления кредитными заявками и клиентами.</p>
                    {{-- <!-- @include('manager.dashboard') --> --}}
                </div>
                
            <!-- Дашборд для аналитика -->
            @elseif(auth()->user()->role_id == 3)
                <div class="alert alert-light">
                    <h4>Панель аналитика</h4>
                    <p class="mb-0">Здесь будет интерфейс для работы с кредитными рисками и аналитикой.</p>
                    {{-- <!-- @include('analyst.dashboard') --> --}}
                </div>

            <!-- Дашборд для администратора -->
            @elseif(auth()->user()->role_id == 4)
                <div class="alert alert-warning">
                    <h4>Административная панель</h4>
                    <p class="mb-0">Здесь будет интерфейс для управления системой и пользователями.</p>
                    {{-- <!-- @include('admin.dashboard') --> --}}
                </div>
            @endif
        @endauth
    </div>

    <style>
        .circular-chart {
            display: block;
            margin: 0 auto;
        }
        
        .circle-bg {
            fill: none;
        }
        
        .circle {
            fill: none;
            animation: progress 1s ease-out forwards;
        }
        
        @keyframes progress {
            0% {
                stroke-dasharray: 0, 100;
            }
        }
        
        .card {
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-2px);
        }
        
        .table th {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
