<?php

namespace App\Application\Actions\Elephpant;

use App\Application\Actions\ActionTwig;
use App\Domain\Elephpant\ElephpantRepositoryInterface;
use Psr\Log\LoggerInterface;

abstract class ElephpantAction extends ActionTwig
{
    protected ElephpantRepositoryInterface $elephpantRepository;

    public function __construct(LoggerInterface $logger, ElephpantRepositoryInterface $elephpantRepository)
    {
        parent::__construct($logger);
        $this->elephpantRepository = $elephpantRepository;
    }
}
