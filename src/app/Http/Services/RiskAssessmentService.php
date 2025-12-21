<?php

namespace App\Services;

use App\Models\ClientsModel;

class RiskAssessmentService
{
    public function calculateClientRisk(ClientsModel $client): float
    {
        $score = 50;
        
        if ($client->credits->count() > 3) $score += 10;
        if ($client->credits->where('rate', '>', 15)->count() > 0) $score += 15;
        
        if ($client->entity_type_id == 1 && $client->individualEntity) {
            if ($client->individualEntity->income < 50000) $score += 10;
            if ($client->individualEntity->credit_history_quality === 'poor') $score += 20;
        }
        
        if ($client->entity_type_id == 2 && $client->legalEntity) {
            if ($client->legalEntity->profitability === 'low') $score += 15;
        }
        
        return min($score, 100);
    }
    
    public function getRiskLevel(float $score): string
    {
        if ($score <= 30) return 'low';
        if ($score <= 60) return 'medium';
        if ($score <= 80) return 'high';
        return 'critical';
    }
}