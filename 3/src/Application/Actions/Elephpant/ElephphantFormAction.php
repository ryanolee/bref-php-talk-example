<?php

namespace App\Application\Actions\Elephpant;

use Psr\Http\Message\ResponseInterface;
class ElephphantFormAction extends ElephpantAction
{
    protected function action(): ResponseInterface
    {
        return $this->render('pages/form.html.twig');
    }
}
