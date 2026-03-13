<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    
    public $table      = "product_category";
    public $primaryKey = 'prod_cat_id';
    public $timestamps = false;
    
    protected $fillable = [
        'brand_id',
        'prod_cat_name	',
        'create_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];

    public function brand()
{
    return $this->belongsTo(ProductBrand::class, 'brand_id', 'brand_id');
}
}