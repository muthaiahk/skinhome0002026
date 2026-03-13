<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentCategory extends Model
{
    use HasFactory;

    public $table      = "treatment_category";
    public $primaryKey = 'tcategory_id';
    public $timestamps = false;

    protected $fillable = [
        'tc_name',
        'tc_description',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];
}
