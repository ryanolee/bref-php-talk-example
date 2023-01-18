<?php

namespace App\Application\Actions\Api\Elephpant;

use App\Application\Actions\Action;
use App\Application\Settings\SettingsInterface;
use App\Domain\Elephpant\ElephpantRepositoryInterface;
use Aws\S3\S3Client;
use Psr\Log\LoggerInterface;

abstract class ElephpantApiAction extends Action
{
    protected ElephpantRepositoryInterface $elephpantRepository;

    protected S3Client $s3Client;

    protected SettingsInterface $settings;

    public function __construct(LoggerInterface $logger, ElephpantRepositoryInterface $elephpantRepository, S3Client $s3Client, SettingsInterface $settings)
    {
        parent::__construct($logger);
        $this->elephpantRepository = $elephpantRepository;
        $this->s3Client = $s3Client;
        $this->settings = $settings;
    }
}
