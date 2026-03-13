<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    public $table      = "treatment";
    public $primaryKey = 'treatment_id';
    public $timestamps = false;

    protected $fillable = [
        'tc_id',
        'treatment_name',
        'treatment_description',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status',
    ];

    public function category() {
    return $this->belongsTo(TreatmentCategory::class, 'tc_id', 'tcategory_id');
}
}