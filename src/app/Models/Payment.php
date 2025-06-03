<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';
    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = ['credit_id', 'amount', 'datetime'];
    
    public $timestamps = false;
    
    public function credit(): BelongsTo
    {
        return $this->belongsTo(Credit::class, 'credit_id');
    }
}
