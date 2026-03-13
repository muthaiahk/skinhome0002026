<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentPayment extends Model
{
    use HasFactory;
    public $table      = "appointment_payment";
    public $primaryKey = 'app_pay_id';
    public $timestamps = false;

    protected $fillable = [
        'app_id',
        'mode',
        'amount',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'status',
    ];
}
