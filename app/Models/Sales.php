<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    public $table      = "sales";
    public $primaryKey = 'sales_id';
    //public $timestamps = false;
    
    protected $fillable = [
        'customer_id',
        'prod_cat_id',
        'product_id',
        'brand_id',
        'date',
        'quantity',
        'amount',
        'create_by',
        'created_at',
        'updated_at',
        'updated_by',
        'status',
        'branch_id',
    ];
}
