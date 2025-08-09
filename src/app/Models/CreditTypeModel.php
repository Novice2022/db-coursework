<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditTypeModel extends Model
{
    protected $table = 'credit_type';
    
    protected $fillable = ['entity_type_id', 'name', 'description'];
    
    public $timestamps = false;
    
    public function entityType(): BelongsTo
    {
        return $this->belongsTo(EntityTypeModel::class, 'entity_type_id');
    }
}
