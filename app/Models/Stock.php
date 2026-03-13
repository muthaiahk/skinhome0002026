<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    public $table      = "stock_maintanance";
    public $primaryKey = 'stock_id';
    public $timestamps = false;

    protected $fillable = [
        'company_id',
        'branch_id',
        'brand_id',
        'prod_cat_id',
        'product_id',
        'stock_in_hand',
        'stock_out',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
