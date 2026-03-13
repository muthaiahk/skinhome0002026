<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    public $table      = "lead";
    public $primaryKey = 'lead_id';
    public $timestamps = false;
    
    protected $fillable = [
        'lead_id',
        'company_id',
        'branch_id',
        'staff_id',
        'lead_first_name',
        'lead_last_name',
        'lead_dob',
        'lead_gender',
        'lead_age',
        'lead_phone',
        'lead_email',
        'lead_address',
        'treatment_id',
        'enquiry_date',
        'lead_status_id',
        'lead_source_id',
        'lead_problem',
        'lead_remark',
        'state_id',
        'convert_status',
        'create_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
