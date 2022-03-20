<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentState extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
