<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление задолженностями | Банк</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .debtor-card {
            transition: all 0.3s;
            border-left: 4px solid;
        }
        .debtor-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .debtor-card.high-risk {
            border-left-color: #dc3545;
        }
        .debtor-card.medium-risk {
            border-left-color: #ffc107;
        }
        .debtor-card.low-risk {
            border-left-color: #28a745;
        }
        .action-btn {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Сайдбар -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <img src="https://via.placeholder.com/150x50?text=Bank+Logo" alt="Логотип банка" class="img-fluid">
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-home me-2"></i>Главная
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-exclamation-triangle me-2"></i>Задолженности
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users me-2"></i>Клиенты
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-credit-card me-2"></i>Кредиты
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-file-invoice-dollar me-2"></i>Штрафы
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-chart-line me-2"></i>Отчеты
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Основное содержимое -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Управление задолженностями</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Новые</button>
                            <button type="button" class="btn btn-sm btn-primary">В работе</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Просроченные</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Все</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-success">
                            <i class="fas fa-plus me-1"></i>Добавить дело
                        </button>
                    </div>
                </div>

                <!-- Фильтры и поиск -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Поиск должников...">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="dropdown d-inline-block me-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Все типы задолженностей
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Кредитные</a></li>
                                <li><a class="dropdown-item" href="#">Ипотечные</a></li>
                                <li><a class="dropdown-item" href="#">По картам</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-filter"></i> Фильтры
                        </button>
                    </div>
                </div>

                <!-- Статистика -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card border-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-danger">Общая задолженность</h6>
                                        <h3 class="card-title">₽24.7M</h3>
                                    </div>
                                    <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-warning">Количество должников</h6>
                                        <h3 class="card-title">147</h3>
                                    </div>
                                    <i class="fas fa-user-times fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-primary">В работе</h6>
                                        <h3 class="card-title">89</h3>
                                    </div>
                                    <i class="fas fa-tasks fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="card-subtitle mb-2 text-success">Возвращено в этом месяце</h6>
                                        <h3 class="card-title">₽3.2M</h3>
                                    </div>
                                    <i class="fas fa-hand-holding-usd fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Список должников -->
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Активные дела</h5>
                            <span class="badge bg-primary">89 дел</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Клиент</th>
                                        <th>Тип задолженности</th>
                                        <th>Сумма</th>
                                        <th>Просрочка</th>
                                        <th>Статус</th>
                                        <th>Риск</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="align-middle">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="https://via.placeholder.com/40" class="rounded-circle" alt="...">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <strong>Иванов П.С.</strong><br>
                                                    <small class="text-muted">ID: 458792</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Кредит наличными</td>
                                        <td class="fw-bold">₽245,000</td>
                                        <td>
                                            <span class="badge bg-danger">45 дней</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark">В работе</span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-danger" style="width: 85%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary action-btn" title="Подробнее">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success action-btn" title="Контакт">
                                                <i class="fas fa-phone"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning action-btn" title="Штраф" data-bs-toggle="modal" data-bs-target="#penaltyModal">
                                                <i class="fas fa-ruble-sign"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="https://via.placeholder.com/40" class="rounded-circle" alt="...">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <strong>Петрова А.К.</strong><br>
                                                    <small class="text-muted">ID: 321456</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Ипотека</td>
                                        <td class="fw-bold">₽1,245,000</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">15 дней</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">Договоренность</span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-warning" style="width: 45%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary action-btn" title="Подробнее">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success action-btn" title="Контакт">
                                                <i class="fas fa-phone"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning action-btn" title="Штраф" data-bs-toggle="modal" data-bs-target="#penaltyModal">
                                                <i class="fas fa-ruble-sign"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <img src="https://via.placeholder.com/40" class="rounded-circle" alt="...">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <strong>Сидоров В.М.</strong><br>
                                                    <small class="text-muted">ID: 789123</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Кредитная карта</td>
                                        <td class="fw-bold">₽78,500</td>
                                        <td>
                                            <span class="badge bg-danger">62 дня</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">Просрочено</span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 6px;">
                                                <div class="progress-bar bg-danger" style="width: 95%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary action-btn" title="Подробнее">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success action-btn" title="Контакт">
                                                <i class="fas fa-phone"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning action-btn" title="Штраф" data-bs-toggle="modal" data-bs-target="#penaltyModal">
                                                <i class="fas fa-ruble-sign"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Назад</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Вперед</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

                <!-- Карточки должников -->
                <h5 class="mb-3">Приоритетные дела</h5>
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card debtor-card high-risk">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">Иванов П.С.</h5>
                                        <small class="text-muted">ID: 458792</small>
                                    </div>
                                    <img src="https://via.placeholder.com/50" class="rounded-circle" alt="...">
                                </div>
                                <div class="mb-3">
                                    <span class="badge bg-danger me-2">Высокий риск</span>
                                    <span class="badge bg-warning text-dark">45 дней</span>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Кредит наличными</span>
                                        <strong>₽245,000</strong>
                                    </div>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-danger" style="width: 85%"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-sm btn-outline-primary">Подробнее</button>
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#penaltyModal">Наложить штраф</button>
                                    <button class="btn btn-sm btn-outline-success">Контакт</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card debtor-card medium-risk">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">Петрова А.К.</h5>
                                        <small class="text-muted">ID: 321456</small>
                                    </div>
                                    <img src="https://via.placeholder.com/50" class="rounded-circle" alt="...">
                                </div>
                                <div class="mb-3">
                                    <span class="badge bg-warning text-dark me-2">Средний риск</span>
                                    <span class="badge bg-warning text-dark">15 дней</span>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Ипотека</span>
                                        <strong>₽1,245,000</strong>
                                    </div>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-warning" style="width: 45%"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-sm btn-outline-primary">Подробнее</button>
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#penaltyModal">Наложить штраф</button>
                                    <button class="btn btn-sm btn-outline-success">Контакт</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card debtor-card high-risk">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div>
                                        <h5 class="card-title mb-1">Сидоров В.М.</h5>
                                        <small class="text-muted">ID: 789123</small>
                                    </div>
                                    <img src="https://via.placeholder.com/50" class="rounded-circle" alt="...">
                                </div>
                                <div class="mb-3">
                                    <span class="badge bg-danger me-2">Высокий риск</span>
                                    <span class="badge bg-danger">62 дня</span>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Кредитная карта</span>
                                        <strong>₽78,500</strong>
                                    </div>
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar bg-danger" style="width: 95%"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-sm btn-outline-primary">Подробнее</button>
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#penaltyModal">Наложить штраф</button>
                                    <button class="btn btn-sm btn-outline-success">Контакт</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Модальное окно для штрафа -->
    <div class="modal fade" id="penaltyModal" tabindex="-1" aria-labelledby="penaltyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penaltyModalLabel">Наложение штрафа</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="clientName" class="form-label">Клиент</label>
                            <input type="text" class="form-control" id="clientName" value="Иванов П.С." readonly>
                        </div>
                        <div class="mb-3">
                            <label for="clientId" class="form-label">ID клиента</label>
                            <input type="text" class="form-control" id="clientId" value="458792" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="debtAmount" class="form-label">Сумма задолженности</label>
                            <input type="text" class="form-control" id="debtAmount" value="₽245,000" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="penaltyType" class="form-label">Тип штрафа</label>
                            <select class="form-select" id="penaltyType">
                                <option selected>Выберите тип</option>
                                <option value="1">Просрочка платежа</option>
                                <option value="2">Неуведомление об изменении данных</option>
                                <option value="3">Нарушение условий договора</option>
                                <option value="4">Другой</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="penaltyAmount" class="form-label">Сумма штрафа</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="penaltyAmount" placeholder="Введите сумму">
                                <span class="input-group-text">₽</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="penaltyComment" class="form-label">Комментарий</label>
                            <textarea class="form-control" id="penaltyComment" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary">Применить штраф</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
