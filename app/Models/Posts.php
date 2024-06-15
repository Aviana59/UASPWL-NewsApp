<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Posts extends Model
{
    use HasFactory;
    protected $table = 'posts';

    protected $fillable = [
        'title',
        'seotitle',
        'user_id',
        'content',
        'image',
        'hits',
        'achive',
        'status',
    ];

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Categories::class, 'category_posts', 'post_id', 'category_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
