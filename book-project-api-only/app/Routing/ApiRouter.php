<?php

namespace App\Routing;

use App\Api\ApiResponse;
use App\Api\BookApiController;
use App\Api\WriterApiController;
use App\Api\PublisherApiController;
use App\Api\CategoryApiController;

class ApiRouter
{
    public function handle(): void
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        // Allow POST override like the UI router (optional)
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        // Strip /api prefix
        $prefix = '/api';
        if (!str_starts_with($path, $prefix)) {
            ApiResponse::fail("Not an API request", 404);
        }

        $route = substr($path, strlen($prefix)); // e.g. /books/1
        if ($route === '') $route = '/';

        try {
            $this->dispatch($method, $route);
        } catch (\Throwable $e) {
            ApiResponse::fail("Server error", 500, $e->getMessage());
        }
    }

    private function dispatch(string $method, string $route): void
    {
        // BOOKS
        if ($route === '/books' && $method === 'GET') {
            (new BookApiController())->index();
        }
        if ($route === '/books/list' && $method === 'GET') {
            (new BookApiController())->list();
        }
        if ($route === '/books/search' && $method === 'GET') {
            (new BookApiController())->search();
        }
        if ($route === '/books' && $method === 'POST') {
            (new BookApiController())->create();
        }
        if (preg_match('#^/books/(\d+)$#', $route, $m)) {
            $id = (int)$m[1];
            if ($method === 'GET') (new BookApiController())->show($id);
            if ($method === 'PUT') (new BookApiController())->update($id);
            if ($method === 'DELETE') (new BookApiController())->delete($id);
        }
        if (preg_match('#^/books/(\d+)/reviews$#', $route, $m) && $method === 'GET') {
            (new BookApiController())->reviews((int)$m[1]);
        }
        if (preg_match('#^/books/(\d+)/rating$#', $route, $m) && ($method === 'POST' || $method === 'RATE')) {
            (new BookApiController())->rating((int)$m[1]);
        }

        // WRITERS
        if ($route === '/writers' && $method === 'GET') (new WriterApiController())->index();
        if ($route === '/writers' && $method === 'POST') (new WriterApiController())->create();
        if (preg_match('#^/writers/(\d+)$#', $route, $m)) {
            $id = (int)$m[1];
            if ($method === 'GET') (new WriterApiController())->show($id);
            if ($method === 'PUT') (new WriterApiController())->update($id);
            if ($method === 'DELETE') (new WriterApiController())->delete($id);
        }

        // PUBLISHERS
        if ($route === '/publishers' && $method === 'GET') (new PublisherApiController())->index();
        if ($route === '/publishers' && $method === 'POST') (new PublisherApiController())->create();
        if (preg_match('#^/publishers/(\d+)$#', $route, $m)) {
            $id = (int)$m[1];
            if ($method === 'GET') (new PublisherApiController())->show($id);
            if ($method === 'PUT') (new PublisherApiController())->update($id);
            if ($method === 'DELETE') (new PublisherApiController())->delete($id);
        }

        // CATEGORIES
        if ($route === '/categories' && $method === 'GET') (new CategoryApiController())->index();
        if ($route === '/categories' && $method === 'POST') (new CategoryApiController())->create();
        if (preg_match('#^/categories/(\d+)$#', $route, $m)) {
            $id = (int)$m[1];
            if ($method === 'GET') (new CategoryApiController())->show($id);
            if ($method === 'PUT') (new CategoryApiController())->update($id);
            if ($method === 'DELETE') (new CategoryApiController())->delete($id);
        }

        ApiResponse::fail("Endpoint not found", 404, ['method' => $method, 'route' => $route]);
    }
}
