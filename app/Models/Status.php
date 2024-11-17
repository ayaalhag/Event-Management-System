<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];
    public function events()
    {
        return $this->hasMany(Event::class, 'status_id');
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


}