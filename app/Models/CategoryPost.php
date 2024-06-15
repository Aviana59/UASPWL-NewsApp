<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class CategoryPost extends Model
{
    use HasFactory;
    protected $table = 'category_posts';
    protected $fillable = [
        'post_id',
        'category_id',
    ];

    public function post(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_posts', 'category_id', 'post_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }
}
