<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        Aws\DynamoDb\DynamoDbClient::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $dynamoDBOptions = $settings->get('dynamodb');

            return new Aws\DynamoDb\DynamoDbClient($dynamoDBOptions);
        },
        Aws\S3\S3Client::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $s3Options = $settings->get('s3');

            return new Aws\S3\S3Client($s3Options);
        },
        Application::class => function (ContainerInterface $container) {
            $settings = $container->get(SettingsInterface::class);
            $application = new Application();

            $application->getDefinition()->addOption(
                new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev')
            );

            foreach ($settings->get('commands') as $class) {
                $application->add($container->get($class));
            }

            return $application;
        },
    ]);
};
