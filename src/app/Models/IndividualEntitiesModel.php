<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndividualEntitiesModel extends Model
{
    protected $table = 'individual_entities';
    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = ['client_id', 'credit_history_id', 'income'];
    
    public $timestamps = false;
    
    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientsModel::class, 'client_id');
    }
    
    public function creditHistory(): BelongsTo
    {
        return $this->belongsTo(CreditHistoryModel::class, 'credit_history_id');
    }
}
