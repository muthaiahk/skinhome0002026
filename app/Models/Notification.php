<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $table      = "notification";
    public $primaryKey = 'notify_id';
    public $timestamps = false;

    protected $fillable = [
        'content',
        'title' ,
        'notify',
        'dashboard',
        'sender_id',
        'receiver_id',
        'alert_status',
        'state',
        'created_by',
        'updated_by',

    ];
}
