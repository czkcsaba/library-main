<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $timestamps = false;
    protected $fillable = ['bookId', 'stars'];

    public function book()
    {
        return $this->belongsTo(Book::class, 'bookId');
    }
}
