<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $table = 'clients';
    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'entity_type_id', 'fullname', 'phone', 'email', 
        'login', 'password', 'address', 'registration_date'
    ];
    
    protected $hidden = ['password'];
    
    public $timestamps = false;
    
    public function entityType(): BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'entity_type_id');
    }
    
    public function legalEntity(): HasOne
    {
        return $this->hasOne(LegalEntity::class, 'client_id');
    }
    
    public function individualEntity(): HasOne
    {
        return $this->hasOne(IndividualEntity::class, 'client_id');
    }
    
    public function credits(): HasMany
    {
        return $this->hasMany(Credit::class, 'client_id');
    }
}
