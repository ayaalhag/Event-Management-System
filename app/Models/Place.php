<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    protected $table = 'places';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'location',
        'phone',
        'category_place_id',
        'picture_url',
        'assessment',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    
    public function category()
    {
        return $this->belongsTo(CategoryPlace::class, 'category_place_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class,'place_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'place_id');
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'place_id');
    }

}
