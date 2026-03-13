<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    use HasFactory;
    public $table      = "lead_status";
    public $primaryKey = 'lead_status_id';
    public $timestamps = false;
    
    protected $fillable = [
        'lead_status_name',
        'lead_status_description',
        'create_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}