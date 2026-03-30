<?php

// Pure JSON API entrypoint
session_start();

require __DIR__ . '/../vendor/autoload.php';

use App\Routing\ApiRouter;
use App\Api\ApiResponse;

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

// Health/info response at non-API paths
if (!str_starts_with($path, '/api')) {
    ApiResponse::ok([
        'message' => 'Library API is running',
        'hint' => 'Try GET /api/books',
    ]);
    exit;
}

$router = new ApiRouter();
$router->handle();
