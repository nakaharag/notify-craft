<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostIt extends Model
{
    use hasFactory;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'color',
        'font_family',
        'font_size',
        'size',
    ];

    /**
     * The user who created this post-it.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
