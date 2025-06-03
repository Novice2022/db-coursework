<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fine extends Model
{
    protected $table = 'fines';
    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = ['credit_id', 'amount', 'reason', 'datetime', 'payed_at'];
    
    public $timestamps = false;
    
    public function credit(): BelongsTo
    {
        return $this->belongsTo(Credit::class, 'credit_id');
    }
}
