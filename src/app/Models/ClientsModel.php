<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientsModel extends Model
{
    protected $table = 'clients';
    
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    
    protected $fillable = [
        'entity_type_id', 'fullname', 'phone', 'email', 
        'login', 'password', 'address', 'registration_date'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'rate' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    protected $hidden = ['password'];

    protected $with = ['entityType'];
    
    public $timestamps = false;
    
    public function entityType(): BelongsTo
    {
        return $this->belongsTo(EntityTypeModel::class, 'entity_type_id');
    }
    
    public function legalEntity(): HasOne
    {
        return $this->hasOne(LegalEntitiesModel::class, 'client_id');
    }
    
    public function individualEntity(): HasOne
    {
        return $this->hasOne(IndividualEntitiesModel::class, 'client_id');
    }
    
    public function credits(): HasMany
    {
        return $this->hasMany(CreditsModel::class, 'client_id');
    }
}
