<?php 

declare(strict_types=1);

namespace App\Application\Actions;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

abstract class ActionTwig extends Action
{
    protected function render(string $template, array $data = []): Response
    {
        $view = Twig::fromRequest($this->request);
        return $view->render($this->response, $template, $data);
    }
}