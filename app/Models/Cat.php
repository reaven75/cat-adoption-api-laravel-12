<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Cat extends Model

{
    protected $fillable = [
        'name',
        'breed',
        'gender',
        'age',
        'location',
        'is_available',
        'is_vaccinated',
        'description',
        'image_url',
    ];

    protected $casts = [
        'is_available'  => 'boolean',
        'is_vaccinated' => 'boolean',
    ];
}
