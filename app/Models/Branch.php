<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
  
    public $table      = "branch";
    public $primaryKey = 'branch_id';
    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'branch_name',
        'branch_location',
        'branch_phone',
        'branch_code',
        'branch_email',
        'branch_authority',
        'branch_opening_date',
        'is_franchise',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];


    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }

    // ✅ Staff Authority Relationship
    public function authority()
    {
        return $this->belongsTo(Staff::class, 'branch_authority', 'staff_id');
    }
}