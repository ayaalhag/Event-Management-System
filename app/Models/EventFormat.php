<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFormat extends Model
{
    protected $table = 'event_formats';
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id',
        'hour',
        'description',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

}
