<?php

namespace App\Http\Repositories;

use App\Models\ClientsModel;

class ClientRepository {
    public static function getIndividualEntityInfo(string $clientId) {
        return ClientsModel::select(
            'fullname',
            'income',
            'credit_history.quality as credit_history_quality',
            'supplement as credit_history_supplement',
        )
            -> join('individual_entities', 'clients.id', '=', 'individual_entities.client_id')
            -> join('credit_history', 'credit_history_id', '=', 'credit_history.id')
            -> where('clients.id', '=', $clientId)
            -> first();
    }
    
    public static function getLegalEntityInfo(string $clientId) {
        return ClientsModel::select(
            'fullname',
            'guarantee_amount',
            'company_industry.name as industry',
            'company_industry.supplement as industry_supplement',
            'profitability.quality as profitability',
            'profitability.supplement as profitability_supplement'
        )
            -> join('legal_entities', 'clients.id', '=', 'legal_entities.client_id')
            -> join('company_industry', 'industry_id', '=', 'company_industry.id')
            -> join('profitability', 'profitability_id', '=', 'profitability.id')
            -> where('clients.id', '=', $clientId)
            -> first();
    }
}
