<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    public $table      = "staff";
    public $primaryKey = 'staff_id';
    public $timestamps = false;

    protected $fillable = [

        'name',
        'date_of_birth',
        'gender',
        'email',
        'phone_no',
        'emergency_contact',
        'address',
        'role_id',
        'date_of_joining',
        'company_id',
        'branch_id',
        'dept_id',
        'desg_id',
        'job_id',      
        'salary',
        'date_of_relieve',
        'profile_pic',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'marital_status',
        'status',
    ];

     public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'department_id');
    }

    // Role relationship
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    // Designation relationship
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'job_id', 'job_id');
    }

    // Optional: company relationship
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'company_id');
    }
    public function getBranchIdsAttribute()
    {
        // branch_id could be null, empty, or string
        if (empty($this->branch_id)) {
            return [];
        }

        // decode JSON, if fails, return array with single id
        $decoded = json_decode($this->branch_id, true);
        if (is_array($decoded)) {
            return $decoded;
        }

        // handle comma-separated string: "1,2,3"
        if (is_string($this->branch_id)) {
            return array_map('trim', explode(',', $this->branch_id));
        }

        return [];
    }
}