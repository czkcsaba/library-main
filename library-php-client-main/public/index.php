<?php
session_start();

require_once __DIR__ . '/../src/Core/helpers.php';
require_once __DIR__ . '/../src/Core/Config.php';
require_once __DIR__ . '/../src/Core/ApiClient.php';
require_once __DIR__ . '/../src/Core/Controller.php';
require_once __DIR__ . '/../src/Controllers/DashboardController.php';
require_once __DIR__ . '/../src/Controllers/BooksController.php';
require_once __DIR__ . '/../src/Controllers/WritersController.php';
require_once __DIR__ . '/../src/Controllers/PublishersController.php';
require_once __DIR__ . '/../src/Controllers/CategoriesController.php';
require_once __DIR__ . '/../src/Controllers/ReviewsController.php';

$config = new Config();
$api = new ApiClient($config);
$section = $_GET['section'] ?? 'dashboard';
$action = $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($action) {
        case 'set_api_url':
            $config->updateApiBaseUrl((string)($_POST['api_base_url'] ?? ''));
            setFlash('success', 'Az API alap URL elmentve.');
            redirectTo($section, $config->getApiBaseUrl());
            break;

        case 'create_book':
            (new BooksController($api, $config))->create();
            break;
        case 'update_book':
            (new BooksController($api, $config))->update();
            break;
        case 'delete_book':
            (new BooksController($api, $config))->delete();
            break;

        case 'create_writer':
            (new WritersController($api, $config))->create();
            break;
        case 'update_writer':
            (new WritersController($api, $config))->update();
            break;
        case 'delete_writer':
            (new WritersController($api, $config))->delete();
            break;

        case 'create_publisher':
            (new PublishersController($api, $config))->create();
            break;
        case 'update_publisher':
            (new PublishersController($api, $config))->update();
            break;
        case 'delete_publisher':
            (new PublishersController($api, $config))->delete();
            break;

        case 'create_category':
            (new CategoriesController($api, $config))->create();
            break;
        case 'update_category':
            (new CategoriesController($api, $config))->update();
            break;
        case 'delete_category':
            (new CategoriesController($api, $config))->delete();
            break;

        case 'save_rating':
            (new ReviewsController($api, $config))->saveRating();
            break;
    }
}

switch ($section) {
    case 'books':
        (new BooksController($api, $config))->index();
        break;
    case 'writers':
        (new WritersController($api, $config))->index();
        break;
    case 'publishers':
        (new PublishersController($api, $config))->index();
        break;
    case 'categories':
        (new CategoriesController($api, $config))->index();
        break;
    case 'reviews':
        (new ReviewsController($api, $config))->index();
        break;
    default:
        (new DashboardController($api, $config))->index();
        break;
}