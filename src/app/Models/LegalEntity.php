<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegalEntity extends Model
{
    protected $table = 'legal_entities';
    
    protected $fillable = [
        'client_id', 'industry_id', 'profitability_id', 'guarantee_amount'
    ];
    
    public $timestamps = false;
    
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    
    public function industry(): BelongsTo
    {
        return $this->belongsTo(CompanyIndustry::class, 'industry_id');
    }
    
    public function profitability(): BelongsTo
    {
        return $this->belongsTo(Profitability::class, 'profitability_id');
    }
}
