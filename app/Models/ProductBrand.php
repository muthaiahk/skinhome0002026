<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;

    public $table      = "brand";
    public $primaryKey = 'brand_id';
    public $timestamps = false;

    protected $fillable = [
        'brand_name',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];

}
