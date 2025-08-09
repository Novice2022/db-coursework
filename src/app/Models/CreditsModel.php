<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CreditsModel extends Model
{
    protected $table = 'credits';
    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'client_id', 'credit_type_id', 'amount', 'rate', 
        'term', 'start_date', 'end_date'
    ];
    
    public $timestamps = false;
    
    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientsModel::class, 'client_id');
    }
    
    public function creditType(): BelongsTo
    {
        return $this->belongsTo(CreditTypeModel::class, 'credit_type_id');
    }
    
    public function payments(): HasMany
    {
        return $this->hasMany(PaymentsModel::class, 'credit_id');
    }
    
    public function fines(): HasMany
    {
        return $this->hasMany(FinesModel::class, 'credit_id');
    }
}
