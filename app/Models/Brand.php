<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';

    protected $primaryKey = 'brand_id';

    public $timestamps = false;

    protected $fillable = [
        'brand_name',
        'created_by',
        'modified_by',
        'status'
    ];

    const CREATED_AT = 'created_on';
    const UPDATED_AT = 'modified_on';
}