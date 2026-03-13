<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadSource extends Model
{
    use HasFactory;
    public $table      = "lead_source";
    public $primaryKey = 'lead_source_id';
    public $timestamps = false;
    
    protected $fillable = [
        'lead_source_name',
        'create_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
