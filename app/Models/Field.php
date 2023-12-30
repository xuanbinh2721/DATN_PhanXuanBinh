<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    public function fieldImages()
    {
        return $this->hasMany(FieldImage::class);
    }
    public function sportType()
    {
        return $this->belongsTo(SportType::class, 'sport_type_id');
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'field_id');
    }
    public function fields() {
        return $this->hasMany(Field::class, 'id'); 
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
}
