<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $table      = "customer";
    public $primaryKey = 'customer_id';
    public $timestamps = false;

    protected $fillable = [
        'branch_id',
        'staff_id',
        'customer_first_name',
        'customer_last_name',
        'customer_dob',
        'customer_gender',
        'customer_age',
        'customer_phone',
        'customer_email',
        'customer_address',
        'treatment_id',
        'lead_status_id',
        'lead_source_id',
        'customer_problem',
        'customer_remark',
        'sitting_count',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
        'state_id'
    ];
    //  public function branch() {
    //     return $this->belongsTo(Branch::class, 'branch_id');
    // }
     public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id');
    }

    public function treatments() {
        return $this->hasMany(Treatment::class);
    }
    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
    public function payments() {
        return $this->hasMany(Payment::class);
    }

}