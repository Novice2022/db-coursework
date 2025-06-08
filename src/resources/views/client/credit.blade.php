<x-app-layout>
    <div class="container py-4 pt-3">
        <div class="row">
            <div class="col-8">
                <div class="p-1">
                    <div class="row p-2 mb-4 alert alert-info">
                        <h4>Общая информация</h4>

                        <hr>

                        <h5>Тип кредита</h5>
                        <p>{{ $credit -> creditType -> name }}</p>
                        
                        <h5>Сумма</h5>
                        <p>{{ $credit -> amount }} руб.</p>
                        
                        <h5>Срок кредитования</h5>
                        <p>{{ $credit -> term }} месяцев</p>
                        
                        <h5>Ставка</h5>
                        <p>{{ $credit -> rate }}%</p>
                        
                        <h5>Дата оформления</h5>
                        <p>{{ $credit -> start_date }}</p>
                    </div>
                    <div class="row">
                        <h4>Платежи</h4>

                        @foreach ($credit -> payments as $payment)
                            <div class="p-2 alert alert-light d-flex justify-content-between">
                                <span>{{ $payment -> amount }}&nbsp;руб.</span>
                                <span>{{ $payment -> datetime }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div> 
            <div class="col-4">
                <div class="p-1">
                    <div @class([
                        'alert',
                        'alert-success' => $credit -> fines -> isEmpty(),
                        'alert-light' => ! $credit -> fines -> isEmpty()
                    ])>
                        <h4>Штрафы</h4>

                        <hr>
                        
                        @if ($credit -> fines -> isEmpty())
                            <p class="m-0">Штрафов нет, всё в порядке!</p>
                        @else
                            @foreach ($credit -> fines as $fine)
                                <div @class([
                                    'alert',
                                    'alert-danger',
                                    'm-0' => $loop -> last
                                ])>
                                    <h4>{{ $fine -> reason }}</h4>
    
                                    <hr>
    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Сумма</span>
                                        <span>{{ $fine -> amount }}&nbsp;руб.</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Дата штрафования</span>
                                        <span>{{ $fine -> datetime }}</span>
                                    </div>
    
                                    <hr>
    
                                    <div class="d-grid">
                                        <button type="button" class="btn btn-outline-secondary" id="fineToastBtn" onclick="handleClickPayFineButton(this.parentElement.parentElement, '{{ $fine -> id }}');">Оплатить</button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="fineToast" class="toast align-items-center text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header d-flex justify-content-between">
                <strong>Уведомление</strong>
                
                <div class="right">
                    <small>сейчаc</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <div class="toast-body">
                Штраф оплачен!
            </div>
        </div>
    </div>

    @if (! $credit -> fines -> isEmpty())
        <script>
            const fineToastTrigger = document.getElementById('fineToastBtn');
            const fineToast = document.getElementById('fineToast');

            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(fineToast);

            function handleClickPayFineButton(fineContainer, fineId) {
                fetch(`{{ route('api.fines.delete', ['id' => ':id']) }}`.replace(':id', fineId), {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response)
                .then(status => {
                    console.log('Успех:', status);
                    alert(status);
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    alert('Произошла ошибка!');
                });

                toastBootstrap.show();

                setTimeout(() => {
                    fineContainer.remove();
                }, 250);
            }
        </script>
    @endif
</x-app-layout>
