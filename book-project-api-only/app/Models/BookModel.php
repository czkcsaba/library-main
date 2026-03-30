<?php

namespace App\Models;

class BookModel extends Model{
    public int|null $writerId = null;
    public int|null $publisherId = null;
    public int|null $categoryId = null;
    public string|null $title = null;
    public string|null $coverImage = null;
    public string|null $ISBN = null;
    public int|null $price = null;
    public string|null $content = null; 

    protected static $table = 'books';

    public function __construct(?int $writerId = null, ?int $publisherId = null, ?int $categoryId = null, ?string $title = null, ?string $coverImage = null, ?string $ISBN = null, ?int $price = null, ?string $content = null){
        parent::__construct();

        if ($writerId){
            $this->writerId = $writerId;
        }

        if ($publisherId){
            $this->publisherId = $publisherId;
        }

        if ($categoryId){
            $this->categoryId = $categoryId;
        }

        if ($title){
            $this->title = $title;
        }

        if ($coverImage){
            $this->coverImage = $coverImage;
        }

        if ($ISBN){
            $this->ISBN = $ISBN;
        }

        if ($price){
            $this->price = $price;
        }

        if ($content){
            $this->content = $content;
        }
    }

    public function getWriter(){
        $writer = new WriterModel();
        return $writer->find($this->writerId);
    }

    public function getPublisher(){
        $publisher = new PublisherModel();
        return $publisher->find($this->publisherId);
    }

    public function getCategory(){
        $category = new CategoryModel();
        return $category->find($this->categoryId);
    }
}