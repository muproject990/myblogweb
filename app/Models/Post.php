<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Comment;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content','user_id','image'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function  comments():HasMany
    {
return $this->hasMany(Comment::class);
    }
}
