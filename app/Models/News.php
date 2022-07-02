<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'link',
        'upvotes'
    ];

    /*
    * Relations
    */

    /**
     * Get the user that owns the News
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function authorName(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_name', 'name');
    }

    /**
     * Get all of the comments for the News
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
