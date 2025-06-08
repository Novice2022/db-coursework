<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Аналитика | Банк</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome для иконок -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .analytics-card {
            transition: transform 0.3s;
        }
        .analytics-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .chart-container {
            height: 300px;
            position: relative;
        }
        .search-box {
            max-width: 400px;
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
                                <i class="fas fa-chart-line me-2"></i>Аналитика
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users me-2"></i>Клиенты
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-credit-card me-2"></i>Продукты
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-file-alt me-2"></i>Отчеты
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog me-2"></i>Настройки
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Основное содержимое -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Аналитический центр</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">День</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Неделя</button>
                            <button type="button" class="btn btn-sm btn-primary">Месяц</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Квартал</button>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
                            <i class="fas fa-download me-1"></i>Экспорт
                        </button>
                    </div>
                </div>

                <!-- Поиск и фильтры -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group search-box">
                            <input type="text" class="form-control" placeholder="Поиск отчетов...">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="dropdown d-inline-block me-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Все отделения
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#">Центральный офис</a></li>
                                <li><a class="dropdown-item" href="#">Северное отделение</a></li>
                                <li><a class="dropdown-item" href="#">Южное отделение</a></li>
                            </ul>
                        </div>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                Все продукты
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <li><a class="dropdown-item" href="#">Кредиты</a></li>
                                <li><a class="dropdown-item" href="#">Вклады</a></li>
                                <li><a class="dropdown-item" href="#">Карты</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Основные метрики -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card analytics-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2">Выданные кредиты</h6>
                                        <h3 class="card-title">₽124.5M</h3>
                                        <span class="badge bg-light text-primary">+12.5%</span>
                                    </div>
                                    <i class="fas fa-hand-holding-usd fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card analytics-card bg-success text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2">Привлеченные вклады</h6>
                                        <h3 class="card-title">₽89.2M</h3>
                                        <span class="badge bg-light text-success">+8.3%</span>
                                    </div>
                                    <i class="fas fa-piggy-bank fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card analytics-card bg-warning text-dark">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2">Новые клиенты</h6>
                                        <h3 class="card-title">1,245</h3>
                                        <span class="badge bg-light text-warning">+5.2%</span>
                                    </div>
                                    <i class="fas fa-user-plus fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card analytics-card bg-info text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-subtitle mb-2">Одобрено заявок</h6>
                                        <h3 class="card-title">78%</h3>
                                        <span class="badge bg-light text-info">+2.1%</span>
                                    </div>
                                    <i class="fas fa-check-circle fa-3x opacity-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <!-- Графики и отчеты -->
                <div class="row mb-4">
                    <div class="col-lg-8 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Динамика выдачи кредитов</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <!-- Здесь будет график -->
                                    <img src="https://via.placeholder.com/800x300?text=График+динамики+кредитов" alt="График" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Распределение по продуктам</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <!-- Здесь будет круговая диаграмма -->
                                    <img src="https://via.placeholder.com/400x300?text=Круговая+диаграмма" alt="Диаграмма" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <!-- Последние отчеты -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Последние отчеты</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Название</th>
                                        <th>Тип</th>
                                        <th>Дата создания</th>
                                        <th>Автор</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Анализ кредитного портфеля за июнь</td>
                                        <td><span class="badge bg-primary">Кредиты</span></td>
                                        <td>01.07.2023</td>
                                        <td>Иванов А.П.</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                            <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Анализ просроченной задолженности</td>
                                        <td><span class="badge bg-warning text-dark">Риски</span></td>
                                        <td>25.06.2023</td>
                                        <td>Сидоров В.К.</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                            <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Отчет по активности клиентов</td>
                                        <td><span class="badge bg-info">Клиенты</span></td>
                                        <td>20.06.2023</td>
                                        <td>Кузнецова О.Л.</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                            <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary">Создать новый отчет</button>
                    </div>
                </div>

                <!-- Быстрый доступ -->
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">Часто используемые отчеты</h6>
                            </div>
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Ежедневный отчет по операциям
                                    <span class="badge bg-primary rounded-pill">25</span>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Кредитный портфель
                                    <span class="badge bg-primary rounded-pill">18</span>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    Вклады по срокам
                                    <span class="badge bg-primary rounded-pill">12</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">Шаблоны отчетов</h6>
                            </div>
                            <div class="list-group list-group-flush">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-excel me-2 text-success"></i>Финансовый отчет (Excel)
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-pdf me-2 text-danger"></i>Ежемесячный отчет (PDF)
                                </a>
                                <a href="#" class="list-group-item list-group-item-action">
                                    <i class="fas fa-file-word me-2 text-primary"></i>Аналитическая записка (Word)
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="card-title mb-0">Быстрые действия</h6>
                            </div>
                            <div class="card-body">
                                <button class="btn btn-outline-primary w-100 mb-2">
                                    <i class="fas fa-plus me-2"></i>Создать отчет
                                </button>
                                <button class="btn btn-outline-secondary w-100 mb-2">
                                    <i class="fas fa-filter me-2"></i>Настроить фильтры
                                </button>
                                <button class="btn btn-outline-success w-100">
                                    <i class="fas fa-share-alt me-2"></i>Поделиться
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
