<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPart extends Model
{
    use HasFactory;
    protected $table = 'catgories_part';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function category()
    {
        return $this->hasMany(Part::class,'catgory_part_id');
    }
}
