<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
  
    public $table      = "company";
    public $primaryKey = 'company_id';
    public $timestamps = false;

    protected $fillable = [
        'company_name',
    ];
}
