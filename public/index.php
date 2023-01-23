<?php

/**
 * StoreDoc
 * @author a.baklankin
 * @version 0.1 (25.04.2022)
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);

require '../vendor/autoload.php';

use Config\Config;
use Middleware\AuthByToken;
use Database\Database;
use Controllers\UploadController;
use Controllers\GetController;
use Controllers\IndexController;
use Slim\App;
use Slim\Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

Database::init();

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
    'upload_directory' => __DIR__ . Config::CONFIG_FILE_UPLOAD_PATH,
];

$c      = new Container($configuration);
$app    = new App($c);

// Middleware: авторизация по токену
$app->add(new AuthByToken());

// * Загрузка файла
$app->post('/upload', function (Request $request, Response $response) 
{
    return UploadController::upload($this, $request, $response);        
});

// * Получить файл
$app->get('/get', function (Request $request, Response $response) 
{
    return GetController::index($this, $request, $response);
});

// * Главная (тестовая) 
$app->get('/', function (Request $request, Response $response) 
{
    return IndexController::index($this, $request, $response);
});

$app->run();
