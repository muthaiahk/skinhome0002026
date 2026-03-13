<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
  
    public $table      = "department";
    public $primaryKey = 'department_id';
    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'designation',
        'branch_id',
        'department_name',
        'dept_incharge',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
