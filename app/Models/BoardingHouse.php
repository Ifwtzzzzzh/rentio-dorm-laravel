<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardingHouse extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',
        'name',
        'thumbnail',
        'city_id',
        'category_id',
        'price',
        'address'
    ];

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}