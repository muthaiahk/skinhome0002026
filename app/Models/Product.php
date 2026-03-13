<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductBrand;
use App\Models\ProductCategory;

class Product extends Model
{
    use HasFactory;

    public $table      = "product";
    public $primaryKey = 'product_id';
    public $timestamps = false;
    
    protected $fillable = [
        'product_name',
        'prod_cat_id',
        'brand_id',
        'amount',
        'create_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];

    // RELATION WITH BRAND
    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id', 'brand_id');
    }

    // RELATION WITH CATEGORY
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'prod_cat_id', 'prod_cat_id');
    }
}