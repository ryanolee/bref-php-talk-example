<?php

declare(strict_types=1);

use App\Application\Actions\Api\Elephpant\CreateElephpantAction;
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
        $response->withHeader('Access-Control-Allow-Origin', '*');
        $response->withHeader('Access-Control-Allow-Headers', 'POST');
        return $response;
    });

    $app->get('/', ListPhpElephantAction::class)->setName('home');
    $app->get('/form', ElephphantFormAction::class)->setName('form');

    $app->group('/api/v1', function (Group $group) {
        $group->post('/elephpant', CreateElephpantAction::class);
    });
};
