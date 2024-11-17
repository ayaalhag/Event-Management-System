<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'type',
        'status_id',
        'place_id',
        'name',
        'additions',
        'nameOnTheCard',
        'music',
        'picture_url',
        'assessment',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function eventFormat()
    {
        return $this->hasOne(EventFormat::class, 'event_id');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'event_part', 'event_id', 'part_id','id','id')
            ->withPivot('number');
    }
    public function bookings()
    {
        return $this->hasOne(Booking::class, 'event_id');
    }
    public function calculateCost()
    {
        $parts = $this->parts()->get();
        $totalPrice = 0;
            foreach ($parts as $part) {
                $part_price = $part->price;
                $part_number = $part->pivot->number;
                $totalPrice += $part_price * $part_number;
            }
        return $totalPrice;
    }

}
