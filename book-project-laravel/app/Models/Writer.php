<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Writer extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'bio'];

    public function books()
    {
        return $this->hasMany(Book::class, 'writerId');
    }
}
