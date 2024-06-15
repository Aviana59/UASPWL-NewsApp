<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'title',
        'seotitle',
        'active',
    ];

    public function post(): HasMany
    {
        return $this->hasMany(Posts::class, 'category_posts', 'categories_id', 'posts_id');
    }
}
