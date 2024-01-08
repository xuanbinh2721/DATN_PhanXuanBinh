<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeFrame extends Model
{
    use HasFactory;
    protected $table = 'timeframes';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'field_id',
        'start_time',
        'end_time',
        'date',
        'price', 

    ];
}
