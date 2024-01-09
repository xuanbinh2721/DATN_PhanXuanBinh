<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id' ,
        'name',
        'phone_number' ,
        'description' ,
        'sport_type_id' ,
        'province_id' ,
        'district_id' ,
        'ward_id' ,
        'address' ,
    ];
    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class, 'field_id');
    }

    public function fieldImages()
    {
        return $this->hasMany(FieldImage::class);
    }
    public function sportType()
    {
        return $this->belongsTo(SportType::class, 'sport_type_id');
    }

    public function timeFrames()
    {
        return $this->hasMany(TimeFrame::class, 'field_id');
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
