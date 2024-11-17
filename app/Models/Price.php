<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $table = 'prices';
    protected $primaryKey = 'id';
    protected $fillable = [
        'place_id',
        'price',
        'start_time',
        'end_time',
     ];

     protected $hidden = [
        'created_at',
        'updated_at',
    ];
    

     public function place()
     {
         return $this->belongsTo(Place::class, 'place_id');
     }
}
