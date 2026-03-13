<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    
    use HasFactory;
    public $table      = "attendance";
    public $primaryKey = 'attendance_id';
    public $timestamps = false;

    protected $fillable = [
        'staff_id',
        'staff_name',
        'job_id',
        'attendance_status',
        'from_date',
        'to_date',
        'present',
        'permission',
        'leave',
        'leave_remarks',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
        ];
}