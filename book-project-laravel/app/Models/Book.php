<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'writerId', 'publisherId', 'categoryId', 'title', 'coverImage', 'ISBN', 'price', 'content'
    ];

    public function writer()
    {
        return $this->belongsTo(Writer::class, 'writerId');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisherId');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'bookId');
    }

    public function getAverageStarsAttribute(): float
    {
        return round((float) $this->reviews()->avg('stars'), 1);
    }
}
