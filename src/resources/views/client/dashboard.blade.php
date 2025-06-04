<section>
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="mb-3">Добро пожаловать, {{ Auth::user()->name }}!</h3>
                    <p class="text-muted mb-4">Ваш текущий статус: <span class="badge bg-success">Активный</span></p>
                    <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#newCreditModal">
                        <i class="bi bi-plus-circle me-2"></i>Новая заявка на кредит
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="mb-3">Кредитный рейтинг</h5>
                    <div class="text-center my-auto">
                        <div class="position-relative d-inline-block">
                            <svg width="120" height="120" viewBox="0 0 36 36" class="circular-chart">
                                <path class="circle-bg"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none"
                                    stroke="#eee"
                                    stroke-width="3"/>
                                <path class="circle"
                                    stroke-dasharray="75, 100"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                    fill="none"
                                    stroke="#0d6efd"
                                    stroke-width="3"
                                    stroke-linecap="round"/>
                            </svg>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <span class="fw-bold fs-3">75</span>
                            </div>
                        </div>
                        <p class="mt-2 mb-0 text-muted">Хороший рейтинг</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Активные кредиты клиента -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">Мои кредиты</h4>
                        <a href="#" class="btn btn-sm btn-outline-primary">История всех кредитов</a>
                    </div>
                    
                    {{-- @if($credits && $credits->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Тип кредита</th>
                                        <th>Сумма</th>
                                        <th>Ставка</th>
                                        <th>Срок</th>
                                        <th>Дата оформления</th>
                                        <th>Статус</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($credits as $credit)
                                        <tr>
                                            <td>{{ $credit->creditType->name }}</td>
                                            <td>{{ number_format($credit->amount, 2, '.', ' ') }} ₽</td>
                                            <td>{{ $credit->rate }}%</td>
                                            <td>{{ $credit->term }} мес.</td>
                                            <td>{{ $credit->start_date->format('d.m.Y') }}</td>
                                            <td>
                                                @if($credit->end_date && $credit->end_date < now())
                                                    <span class="badge bg-secondary">Завершен</span>
                                                @else
                                                    <span class="badge bg-success">Активный</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('credits.show', $credit->id) }}" class="btn btn-sm btn-outline-primary">Подробнее</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            У вас нет активных кредитов. Вы можете оформить новый кредит, нажав на кнопку "Новая заявка на кредит".
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
    
    <!-- Модальное окно для новой заявки -->
    <div class="modal fade" id="newCreditModal" tabindex="-1" aria-labelledby="newCreditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newCreditModalLabel">Новая заявка на кредит</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- <form method="POST" action="{{ route('credits.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="credit_type_id" class="form-label">Тип кредита</label>
                            <select class="form-select" id="credit_type_id" name="credit_type_id" required>
                                <option value="" selected disabled>Выберите тип кредита</option>
                                {{-- @foreach($creditTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Сумма кредита (₽)</label>
                            <input type="number" class="form-control" id="amount" name="amount" min="1000" max="10000000" required>
                        </div>
                        <div class="mb-3">
                            <label for="term" class="form-label">Срок (месяцев)</label>
                            <input type="number" class="form-control" id="term" name="term" min="1" max="120" required>
                        </div>
                        <div class="mb-3">
                            <label for="purpose" class="form-label">Цель кредита</label>
                            <textarea class="form-control" id="purpose" name="purpose" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Подать заявку</button>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
</section>