<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditHistory extends Model
{
    protected $table = 'credit_history';
    
    protected $fillable = ['quality', 'supplement'];
    
    public $timestamps = false;
}
