<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyIndustry extends Model
{
    protected $table = 'company_industry';
    
    protected $fillable = ['name', 'supplement'];
    
    public $timestamps = false;
}
