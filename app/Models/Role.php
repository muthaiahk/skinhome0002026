<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
 
    public $table      = "role";
    public $primaryKey = 'role_id';
    public $timestamps = false;
    
    protected $fillable = [
        'role_name',
        'role_discription',
        'create_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
