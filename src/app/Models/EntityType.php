<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityType extends Model
{
    protected $table = 'entity_type';
    
    protected $fillable = ['name'];
    
    public $timestamps = false;
}
