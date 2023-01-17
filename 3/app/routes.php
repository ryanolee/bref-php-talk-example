<?php

declare(strict_types=1);

use App\Application\Actions\Elephpant\{ElephphantFormAction, ListPhpElephantAction};
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Views\Twig;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', ListPhpElephantAction::class)->setName('home');
    $app->get('/form', ElephphantFormAction::class)->setName('form');
};
