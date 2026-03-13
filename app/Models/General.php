<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    use HasFactory;
 
    public $table      = "general_settings";
    public $primaryKey = 'g_set_id';
    public $timestamps = false;
    protected $fillable = [
        'company_id',
        'company_name',
        'logo',
        'favicon',
        'default_pic',
        'established_date',
        'company_address',
        'contact_person',
        'phone_no',
        'email',
        'website',
        'timezone',
        'currency',
        'language',
        'gst_no',
        'pan_no',
        'date_format',
        'created_dt',
        'modified_dt',
    ];
}
