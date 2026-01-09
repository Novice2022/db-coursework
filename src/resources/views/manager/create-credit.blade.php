@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Выдача нового кредита</h1>
        <a href="{{ route('manager.credits.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i> Назад
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Форма выдачи кредита</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('manager.credits.store') }}">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Клиент *</label>
                                <select name="client_id" class="form-select" required>
                                    <option value="">Выберите клиента</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->fullname }} ({{ $client->entityType->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Тип кредита *</label>
                                <select name="credit_type_id" class="form-select" required>
                                    <option value="">Выберите тип кредита</option>
                                    @foreach($creditTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Сумма кредита (₽) *</label>
                                <input type="number" name="amount" class="form-control" 
                                    min="1000" step="1000" value="100000" required>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label">Процентная ставка (%) *</label>
                                <input type="number" name="rate" class="form-control" 
                                    min="1" max="50" step="0.1" value="12.5" required>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label">Срок (месяцев) *</label>
                                <input type="number" name="term" class="form-control" 
                                    min="1" max="120" value="12" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Дополнительная информация</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            После создания кредита будет сформирован график платежей
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i> Выдать кредит
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Информация о кредите</h5>
                </div>
                <div class="card-body">
                    <p><strong>Порядок выдачи кредита:</strong></p>
                    <ol class="mb-3">
                        <li>Выбор клиента</li>
                        <li>Определение типа кредита</li>
                        <li>Установка суммы и ставки</li>
                        <li>Определение срока</li>
                        <li>Проверка данных</li>
                        <li>Подписание договора</li>
                    </ol>
                    
                    <p><strong>Требования к клиенту:</strong></p>
                    <ul>
                        <li>Заполненный профиль</li>
                        <li>Проверенные документы</li>
                        <li>Соответствие кредитной политике</li>
                    </ul>
                    
                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Проверьте все данные перед выдачей кредита
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Расчет платежей</h5>
        </div>
        <div class="card-body" id="paymentCalculation">
            <div class="text-center text-muted">
                <i class="bi bi-calculator" style="font-size: 2rem;"></i>
                <p class="mt-2">Введите данные кредита для расчета</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.querySelector('input[name="amount"]');
    const rateInput = document.querySelector('input[name="rate"]');
    const termInput = document.querySelector('input[name="term"]');
    const calculationDiv = document.getElementById('paymentCalculation');
    
    function calculatePayment() {
        const amount = parseFloat(amountInput.value) || 0;
        const rate = parseFloat(rateInput.value) || 0;
        const term = parseInt(termInput.value) || 0;
        
        if (amount > 0 && rate > 0 && term > 0) {
            const monthlyRate = rate / 100 / 12;
            const payment = amount * monthlyRate * Math.pow(1 + monthlyRate, term) / 
                        (Math.pow(1 + monthlyRate, term) - 1);
            
            const totalPayment = payment * term;
            const totalInterest = totalPayment - amount;
            
            calculationDiv.innerHTML = `
                <div class="row text-center">
                    <div class="col-md-4">
                        <h5>${payment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ')} ₽</h5>
                        <p class="text-muted">Ежемесячный платеж</p>
                    </div>
                    <div class="col-md-4">
                        <h5>${totalPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ')} ₽</h5>
                        <p class="text-muted">Общая сумма выплат</p>
                    </div>
                    <div class="col-md-4">
                        <h5>${totalInterest.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ')} ₽</h5>
                        <p class="text-muted">Общая сумма процентов</p>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-center">
                        <small class="text-muted">Расчет приблизительный. Точные условия будут указаны в договоре.</small>
                    </p>
                </div>
            `;
        } else {
            calculationDiv.innerHTML = `
                <div class="text-center text-muted">
                    <i class="bi bi-calculator" style="font-size: 2rem;"></i>
                    <p class="mt-2">Введите данные кредита для расчета</p>
                </div>
            `;
        }
    }
    
    amountInput.addEventListener('input', calculatePayment);
    rateInput.addEventListener('input', calculatePayment);
    termInput.addEventListener('input', calculatePayment);
    
    calculatePayment();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.querySelector('input[name="amount"]');
    const rateInput = document.querySelector('input[name="rate"]');
    const termInput = document.querySelector('input[name="term"]');
    const infoDiv = document.getElementById('paymentInfo');
    
    function calculatePayment() {
        const amount = parseFloat(amountInput.value) || 0;
        const rate = parseFloat(rateInput.value) || 0;
        const term = parseInt(termInput.value) || 0;
        
        if (amount > 0 && rate > 0 && term > 0) {
            const monthlyRate = rate / 100 / 12;
            const payment = amount * monthlyRate * Math.pow(1 + monthlyRate, term) / 
                          (Math.pow(1 + monthlyRate, term) - 1);
            
            const totalPayment = payment * term;
            const totalInterest = totalPayment - amount;
            
            document.getElementById('monthlyPayment').textContent = 
                payment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ') + ' ₽';
            document.getElementById('totalPayment').textContent = 
                totalPayment.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ') + ' ₽';
            document.getElementById('totalInterest').textContent = 
                totalInterest.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ') + ' ₽';
        }
    }
    
    amountInput.addEventListener('input', calculatePayment);
    rateInput.addEventListener('input', calculatePayment);
    termInput.addEventListener('input', calculatePayment);
});
</script>
@endsection