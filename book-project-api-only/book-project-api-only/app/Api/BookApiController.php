<?php

namespace App\Api;

use App\Models\BookModel;

class BookApiController extends ApiController
{
    public function list(): void
    {
        $q = $this->query();

        $table = $this->str($q['table'] ?? 'books');
        $attribute = $this->str($q['attribute'] ?? 'title');
        $direction = strtoupper($this->str($q['direction'] ?? 'ASC'));
        if (!in_array($direction, ['ASC', 'DESC'], true)) $direction = 'ASC';

        $model = new BookModel();

        // If caller asks for join-based ordering, use existing helper
        $books = $model->getBooksBy($table, $attribute, $direction);

        ApiResponse::ok($this->serializeBooks($books));
    }

    public function search(): void
    {
        $q = $this->query();

        $table = $this->str($q['table'] ?? 'books');
        $attribute = $this->str($q['attribute'] ?? 'title');
        $text = $this->str($q['text'] ?? '');

        if ($text === '') {
            ApiResponse::ok([]); // empty search -> empty list
        }

        $model = new BookModel();
        $books = $model->searchBooks($table, $attribute, $text);

        ApiResponse::ok($this->serializeBooks($books));
    }

    public function index(): void
    {
        // simple all (without joins)
        $q = $this->query();
        $orderBy = $q['order_by'] ?? null;
        $direction = $q['direction'] ?? null;

        $model = new BookModel();
        $books = $model->all([
            'order_by' => is_array($orderBy) ? $orderBy : (is_string($orderBy) ? [$orderBy] : []),
            'direction' => is_array($direction) ? $direction : (is_string($direction) ? [$direction] : []),
        ]);

        ApiResponse::ok($this->serializeBooks($books));
    }

    public function show(int $id): void
    {
        $model = new BookModel();
        $book = $model->find($id);

        if (!$book) {
            ApiResponse::fail("Book not found", 404);
        }

        ApiResponse::ok($this->serializeBook($book));
    }

    public function create(): void
    {
        $data = $this->body();

        $required = ['writerId', 'publisherId', 'categoryId', 'title', 'ISBN', 'price', 'content'];
        foreach ($required as $k) {
            if (!isset($data[$k]) || $data[$k] === '') {
                ApiResponse::fail("Missing field: {$k}", 422);
            }
        }

        $book = new BookModel();
        $book->writerId = (int)$data['writerId'];
        $book->publisherId = (int)$data['publisherId'];
        $book->categoryId = (int)$data['categoryId'];
        $book->title = (string)$data['title'];
        $book->ISBN = (string)$data['ISBN'];
        $book->price = (int)$data['price'];
        $book->content = (string)$data['content'];

        // cover image: accept LOAD_FILE(...) or uploaded file
        $cover = isset($data['coverImage']) ? (string)$data['coverImage'] : '';
        if ($cover && $this->isLoadFile($cover)) {
            $book->coverImage = $cover;
        } else {
            $uploaded = $this->tmpUploadToLoadFile('coverImage');
            if ($uploaded) {
                $book->coverImage = $uploaded;
            } else {
                ApiResponse::fail("Missing coverImage (provide LOAD_FILE(...) or upload coverImage file)", 422);
            }
        }

        $newId = $book->create();
        if (!$newId) {
            ApiResponse::fail("Create failed", 500, $_SESSION['error_message'] ?? null);
        }

        ApiResponse::ok(['id' => (int)$newId], 201);
    }

    public function update(int $id): void
    {
        $data = $this->body();

        $model = new BookModel();
        $book = $model->find($id);
        if (!$book) {
            ApiResponse::fail("Book not found", 404);
        }

        foreach (['writerId','publisherId','categoryId'] as $k) {
            if (isset($data[$k]) && $data[$k] !== '') $book->$k = (int)$data[$k];
        }
        foreach (['title','ISBN','content'] as $k) {
            if (isset($data[$k]) && $data[$k] !== '') $book->$k = (string)$data[$k];
        }
        if (isset($data['price']) && $data['price'] !== '') $book->price = (int)$data['price'];

        $cover = isset($data['coverImage']) ? (string)$data['coverImage'] : '';
        if ($cover && $this->isLoadFile($cover)) {
            $book->coverImage = $cover;
        } else {
            $uploaded = $this->tmpUploadToLoadFile('coverImage');
            if ($uploaded) {
                $book->coverImage = $uploaded;
            }
        }

        $ok = $book->update();
        if (!$ok) {
            ApiResponse::fail("Update failed", 500, $_SESSION['error_message'] ?? null);
        }

        ApiResponse::ok(['updated' => true]);
    }

    public function delete(int $id): void
    {
        $model = new BookModel();
        $book = $model->find($id);
        if (!$book) {
            ApiResponse::fail("Book not found", 404);
        }

        $ok = $book->delete();
        if (!$ok) {
            ApiResponse::fail("Delete failed", 500, $_SESSION['error_message'] ?? null);
        }

        ApiResponse::ok(['deleted' => true]);
    }

    public function reviews(int $id): void
    {
        $model = new BookModel();
        $book = $model->find($id);
        if (!$book) {
            ApiResponse::fail("Book not found", 404);
        }

        $stars = $model->getBookReview($id);
        ApiResponse::ok($stars);
    }

    public function rating(int $id): void
    {
        $data = $this->body();
        $stars = isset($data['stars']) ? (int)$data['stars'] : (isset($data['starsValue']) ? (int)$data['starsValue'] : 0);
        if ($stars < 1 || $stars > 5) {
            ApiResponse::fail("stars must be 1..5", 422);
        }

        $model = new BookModel();
        $book = $model->find($id);
        if (!$book) {
            ApiResponse::fail("Book not found", 404);
        }

        $model->saveBookRating($id, $stars);
        ApiResponse::ok(['saved' => true]);
    }

    private function serializeBooks(array $books): array
    {
        $out = [];
        foreach ($books as $b) $out[] = $this->serializeBook($b);
        return $out;
    }

    private function serializeBook(BookModel $b): array
    {
        return [
            'id' => (int)$b->id,
            'writerId' => (int)$b->writerId,
            'publisherId' => (int)$b->publisherId,
            'categoryId' => (int)$b->categoryId,
            'title' => (string)$b->title,
            // send coverImage as base64 to be JSON safe
            'coverImage' => substr(base64_encode($b->coverImage ?? ''), 0, 20),
            'ISBN' => (string)$b->ISBN,
            'price' => (int)$b->price,
            'content' => (string)$b->content,
        ];
    }
}
