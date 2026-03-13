<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    public $table      = "appointment";
    public $primaryKey = 'appointment_id';
    public $timestamps = false;

    protected $fillable = [
        'appointment_id',
        'company_id',
        'customer_id',
        'lead_id',
        'staff_id',
        'treatment_id',
        'problem',
        'lead_status_id',
        'app_status',
        'remark',
        'date',
        'time',
        'tc_id',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];

    public function staff()
    {
        return $this->belongsTo(\App\Models\Staff::class, 'staff_id', 'staff_id');
    }
   public function treatment()
    {
        return $this->belongsTo(\App\Models\Treatment::class, 'treatment_id', 'treatment_id');
    }
    public function lead()
{
    return $this->belongsTo(Lead::class, 'lead_id', 'lead_id');
}
}