<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Part extends Model
{
    use HasFactory;
    protected $table = 'event_part';
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id',
        'part_id',
        'number',
     ];
     
     protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
