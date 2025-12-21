<div class="reports-grid">
    <div class="report-card">
        <h3>Отчет по пользователям</h3>
        <p>Список всех пользователей системы</p>
        <div class="report-actions">
            <a href="{{ route('reports.generate', ['type' => 'clients', 'format' => 'pdf']) }}" 
               class="btn btn-danger">PDF</a>
            <a href="{{ route('reports.generate', ['type' => 'clients', 'format' => 'excel']) }}" 
               class="btn btn-success">Excel</a>
        </div>
    </div>
    
    <div class="report-card">
        <h3>Финансовый отчет</h3>
        <p>Финансовая статистика за текущий год</p>
        <div class="report-actions">
            <a href="{{ route('reports.generate', ['type' => 'financial', 'format' => 'pdf']) }}" 
               class="btn btn-danger">PDF</a>
            <a href="{{ route('reports.generate', ['type' => 'financial', 'format' => 'excel']) }}" 
               class="btn btn-success">Excel</a>
        </div>
    </div>
</div>