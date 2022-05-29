<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\NotFoundController;
use App\Controllers\PostController;
use Slim\App;

return function (App $app) {
    $app->get('/', HomeController::class . ':index')->setName('app.home');
    $app->get('/post/{slug}', PostController::class . ':index')->setName('app.post');
    $app->get('/{routes:.*}', NotFoundController::class . ':index')->setName('app.not_found');
};
