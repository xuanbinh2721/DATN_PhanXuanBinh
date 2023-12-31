<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldImage extends Model
{
    use HasFactory;
    protected $table = 'fieldimages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'field_id' ,
        'image_name',
    ];


    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
