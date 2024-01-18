<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SportType extends Model
{
    use HasFactory;
    protected $table = 'sporttypes';

    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    protected $fillable = [
        'name',
        'description',
        'status,'
    ];
}
