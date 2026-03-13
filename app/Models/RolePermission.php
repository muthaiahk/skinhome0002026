<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
 
    public $table      = "role_permission";
    public $primaryKey = 'rp_id';
    public $timestamps = false;
    
    protected $fillable = [
        'role_id',
        'page',
        'permission',
        'create_by',
        'created_at',
        'updated_at',
        'updated_by',
        'status',
    ];
}
