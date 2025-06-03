<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profitability extends Model
{
    protected $table = 'profitability';
    
    protected $fillable = ['quality', 'supplement'];
    
    public $timestamps = false;
}
