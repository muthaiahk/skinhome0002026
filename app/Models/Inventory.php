<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    public $table      = "inventory";
    public $primaryKey = 'inventory_id';
    public $timestamps = false;

    protected $fillable = [
        'inventory_date',
        'company_id',
        'branch_id',
        'brand_id',
        'prod_cat_id',
        'product_id',
        'stock_in_hand',
        'stock_alert_count',
        'description',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
        
        
    ];
}
