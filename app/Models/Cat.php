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



    protected function image(): Attribute
    {
        return Attribute::make(
            // Accessor → ubah nama file jadi URL lengkap
            get: fn($image) => $image ? url('/storage/' . $image) : null,

            // Mutator → simpan hanya nama file, bukan path lengkap
            set: fn($image) => $image instanceof \Illuminate\Http\UploadedFile
                ? $image->store('cats', 'public') // simpan ke storage/app/public/cats
                : $image
        );
    }
}
