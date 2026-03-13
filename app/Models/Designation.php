<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
   
    public $table      = "job_designation";
    public $primaryKey = 'job_id';
    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'designation',
        'description',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
