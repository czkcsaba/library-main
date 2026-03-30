<?php

namespace App\Models;

class WriterModel extends Model{
    public string|null $name = null;
    public string|null $bio = null;

    protected static $table = 'writers';

    public function __construct(?string $name = null, ?string $bio = null){
        parent::__construct();

        if ($name){
            $this->name = $name;
        }

        if ($bio){
            $this->bio = $bio;
        }
    }
}