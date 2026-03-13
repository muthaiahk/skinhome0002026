<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    public $table      = "billing";
    public $primaryKey = 'billing_id';
    public $timestamps = false;

   protected $fillable = [
        'invoice_no',
        'billing_no',
        'receipt_no',
        'payment_date',
        'treatment_category_id',
        'treatment_id',
        'product_category_id',
        'product_id',
        'customer_id',
        'lead_id',
        'paid_amount',
        'total_amount',
        'balance_amount',
        'discount_type',
        'discount_amount',
        'cgst',
        'sgst',
        'payment_status',
        'payment_mode',
        'created_by',
        'created_on',
        'updated_by',
        'updated_on',
        'status',
        
    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function lead() {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }
}

    