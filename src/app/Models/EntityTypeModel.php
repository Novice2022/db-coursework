<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityTypeModel extends Model
{
    protected $table = 'entity_type';
    
    protected $fillable = ['name'];
    
    public $timestamps = false;
}
