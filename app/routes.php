<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\PostController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', HomeController::class . ':index')->setName('app.home');
    $app->get('/post/{slug}', PostController::class . ':index')->setName('app.post');
};
