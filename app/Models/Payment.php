<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table      = "payment";
    protected $primaryKey = 'p_id';
    public $timestamps    = false;

    protected $fillable = [
        'invoice_no','receipt_no','payment_date','tcate_id','treatment_id','product_id',
        'customer_id','lead_id','sitting_count','amount','total_amount','balance',
        'discount','cgst','sgst','payment_status','payment_mode','created_by','created_on',
        'updated_by','updated_on','status','cus_treat_id',
    ];

    // Payment belongs to a treatment
    public function treatment() {
        return $this->belongsTo(Treatment::class, 'treatment_id', 'treatment_id')
                    ->with('category'); // eager load category
    }

    // Payment belongs to a branch
    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    // Payment belongs to a customer
    public function customer() {
        // Adjust 'customer_id' here to match primary key in customers table
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
    public function lead()
{
    return $this->belongsTo(Lead::class,'lead_id','lead_id');
}
}