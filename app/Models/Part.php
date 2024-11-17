<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;
    protected $table = 'parts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'price',
        'pictture_url',
        'assessment',
        'catgory_part_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function category()
    {
        return $this->belongsTo(CategoryPart::class, 'catgory_part_id');
    }

public function events()
{
    return $this->belongsToMany(Event::class, 'event_part', 'part_id', 'event_id','id','id')
        ->withPivot('number');
}
}
