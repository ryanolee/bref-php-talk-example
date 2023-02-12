<?php

namespace App\Application\Actions\Elephpant;

use App\Application\Settings\SettingsInterface;
use App\Domain\Elephpant\ElephpantRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class ElephphantFormAction extends ElephpantAction
{
    protected SettingsInterface $settings;
    public function __construct(LoggerInterface $logger, ElephpantRepositoryInterface $elephpantRepository, SettingsInterface $settings)
    {
        parent::__construct($logger, $elephpantRepository);
        $this->settings = $settings;
    }

    protected function action(): ResponseInterface
    {
        return $this->render('pages/form.html.twig', [
            'api_host' => $this->settings->get('apiHost'),
        ]);
    }
}
