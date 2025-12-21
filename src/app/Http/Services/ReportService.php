<?php

namespace App\Services;

use App\Models\CreditsModel;
use App\Models\ClientsModel;
use App\Models\FinesModel;
use App\Models\PaymentsModel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportService
{
    private $riskAssessmentService;
    
    public function __construct(RiskAssessmentService $riskAssessmentService)
    {
        $this->riskAssessmentService = $riskAssessmentService;
    }
    
    public function generateMonthlyReport($user, $startDate, $endDate)
    {
        // Вынесенная логика из контроллеров
    }
    
    public function generateClientsReport($user)
    {
        if (!$user->isManager() && !$user->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }
        
        return ClientsModel::with(['entityType', 'credits'])
            ->orderBy('registration_date', 'desc')
            ->get()
            ->map(function ($client) {
                $client->risk_score = $this->riskAssessmentService->calculateClientRisk($client);
                $client->risk_level = $this->riskAssessmentService->getRiskLevel($client->risk_score);
                return $client;
            });
    }
    
    public function downloadPdf($data, $type, $viewName = null)
    {
        $viewName = $viewName ?: "reports.pdf.{$type}";
        
        if (!view()->exists($viewName)) {
            $viewName = "reports.pdf.monthly";
        }
        
        $pdf = Pdf::loadView($viewName, compact('data'));
        $filename = 'report_' . $type . '_' . now()->format('Y_m_d') . '.pdf';
        
        return $pdf->download($filename);
    }
}