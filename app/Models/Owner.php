<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    public $table="owners";

    protected $fillable = ['name', 'phone', 'address', 'balance'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
