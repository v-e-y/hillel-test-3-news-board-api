<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    /*
    * Relations
    */

    /**
     * Get the user (author) that owns the Comment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function authorName(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_name', 'name');
    }

    /**
     * Get the news that owns the Comment
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
