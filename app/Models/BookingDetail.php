<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;
    protected $table = 'bookingdetails';

    protected $fillable = [
        'field_id',
        'user_id',
        'time_frame_id',
        'name',
        'email',
        'phone_number',
        'status', 
        'payment_method',
        'note',
    ];
    public function timeFrames()
    {
        return $this->belongsTo(TimeFrame::class, 'time_frame_id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

}
