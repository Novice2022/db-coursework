<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegalEntitiesModel extends Model
{
    protected $table = 'legal_entities';
    
    protected $fillable = [
        'client_id', 'industry_id', 'profitability_id', 'guarantee_amount'
    ];
    
    public $timestamps = false;
    
    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientsModel::class, 'client_id');
    }
    
    public function industry(): BelongsTo
    {
        return $this->belongsTo(CompanyIndustryModel::class, 'industry_id');
    }
    
    public function profitability(): BelongsTo
    {
        return $this->belongsTo(ProfitabilityModel::class, 'profitability_id');
    }
}
