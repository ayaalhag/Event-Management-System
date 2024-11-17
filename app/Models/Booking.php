<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Booking extends Model
{
    use HasFactory;


    protected $table = 'bookings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'start_date',
        'end_date',
        'event_id',
        'place_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the place associated with the booking.
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Get the price associated with the booking.
     */
    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    public function calculateCost()
    {
        $startDate = Carbon::parse($this->start_date)->format('H:i:s');
        $endDate = Carbon::parse($this->end_date)->format('H:i:s');

        $prices =Price::where('place_id',$this->place_id)->get();

        $totalCost = 0;

        foreach ($prices as $price) {
            $priceStartTime = Carbon::parse($price->start_time)->format('H:i:s');
            $priceEndTime = Carbon::parse($price->end_time)->format('H:i:s');
            if ($startDate <= $priceEndTime && $endDate >= $priceStartTime) {
                $overlapStart = max($startDate,$priceStartTime);
                $overlapEnd = min($endDate,$priceEndTime);

                $hours = (strtotime($overlapEnd) - strtotime($overlapStart)) / 3600;

                $totalCost += $hours * $price->price;
            }

        }

        return $totalCost;
    }

}
