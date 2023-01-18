<?php

declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Views\{Twig, TwigMiddleware};

return function (App $app) {
    $app->add(SessionMiddleware::class);

    // Create Twig
    $twig = Twig::create(__DIR__ . '/../templates', ['cache' => false]);
    $app->add(TwigMiddleware::create($app, $twig));
};
