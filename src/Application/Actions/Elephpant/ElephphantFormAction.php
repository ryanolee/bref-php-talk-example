<?php

namespace App\Application\Actions\Elephpant;

use App\Application\Settings\SettingsInterface;
use App\Domain\Elephpant\ElephpantRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class ElephphantFormAction extends ElephpantAction
{
    protected function action(): ResponseInterface
    {
        return $this->render('pages/form.html.twig');
    }
}
