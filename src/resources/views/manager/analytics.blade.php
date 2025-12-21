<div class="analytics-section">
    <h3>Выгрузка отчетов</h3>
    <div class="report-options">
        <a href="{{ route('reports.generate', ['type' => 'credits', 'format' => 'pdf']) }}" 
           class="btn btn-sm btn-outline-danger">PDF отчет по кредитам</a>
        <a href="{{ route('reports.generate', ['type' => 'clients', 'format' => 'excel']) }}" 
           class="btn btn-sm btn-outline-success">Excel отчет по клиентам</a>
        <a href="{{ route('analyst.reports.download', ['type' => 'risk']) }}" 
           class="btn btn-sm btn-outline-primary">Отчет по рискам</a>
    </div>
</div>