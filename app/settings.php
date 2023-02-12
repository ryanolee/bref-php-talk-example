<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            $dynamoDBOptions = [
                'region'  => 'eu-west-1',
                'version' => 'latest',
            ];

            if(isset($_ENV["SERVERLESS_STAGE"]) && $_ENV["SERVERLESS_STAGE"] === "local") {
                $dynamoDBOptions['endpoint'] = 'http://dynamodb:8000';
                $dynamoDBOptions['credentials'] = [
                    'key' => 'local',
                    'secret' => 'local',
                ];
            }

            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => 'php://stdout',
                    'level' => Logger::DEBUG,
                ],
                'dynamodb' => $dynamoDBOptions,
                'commands' => [
                    \App\Console\BootstrapCommand::class
                ]
            ]);
        }
    ]);
};
