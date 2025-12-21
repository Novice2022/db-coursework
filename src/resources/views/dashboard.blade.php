@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h1 class="display-4">Добро пожаловать, {{ auth()->user()->name }}!</h1>
                    <p class="lead">Вы вошли как {{ auth()->user()->getRoleName() }}</p>
                    
                    <div class="mt-4">
                        @if(auth()->user()->role_id == 1)
                            <a href="{{ route('client.dashboard') }}" class="btn btn-primary btn-lg">
                                Перейти в мой кабинет
                            </a>
                        @elseif(auth()->user()->role_id == 2)
                            <a href="{{ route('manager.dashboard') }}" class="btn btn-success btn-lg">
                                Панель менеджера
                            </a>
                        @elseif(auth()->user()->role_id == 3)
                            <a href="{{ route('analyst.dashboard') }}" class="btn btn-warning btn-lg">
                                Панель аналитика
                            </a>
                        @elseif(auth()->user()->role_id == 4)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-lg">
                                Панель администратора
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection