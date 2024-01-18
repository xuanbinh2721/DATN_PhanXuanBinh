<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';

    protected $fillable = [
        'field_id' ,
        'user_id',
        'feedback' ,
        'rate' ,
        'status' ,
    ];

    public function field()
    {
        return $this->belongsTo(Field::class, 'field_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'feedback_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
