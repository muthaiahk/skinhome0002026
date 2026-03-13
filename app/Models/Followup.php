<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    use HasFactory;

    public $table      = "followup_history";
    public $primaryKey = 'followup_id';
    public $timestamps = false;
    
    protected $fillable = [
        'lead_id',
        'followup_count',
        'next_followup_date',
        'followup_date',
        'app_status',
        'remark',
        'create_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
