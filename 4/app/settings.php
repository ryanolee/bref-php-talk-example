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

            $s3Options = [
                'region'  => 'eu-west-1',
                'version' => 'latest',
            ];

            $apiHost = '';

            if(isset($_ENV["SERVERLESS_STAGE"]) && $_ENV["SERVERLESS_STAGE"] === "local") {
                $dynamoDBOptions['endpoint'] = 'http://localstack:4566';
                $dynamoDBOptions['credentials'] = [
                    'key' => 'local',
                    'secret' => 'local',
                ];

                $s3Options['endpoint'] = 'http://localstack:4566';
                $s3Options['credentials'] = [
                    'key' => 'local',
                    'secret' => 'local',
                ];

                $s3Options["use_path_style_endpoint"] = true;

                $s3Options["bucketName"] = "elephpants-4";

                $apiHost = 'http://localhost:8081';
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
                's3' => $s3Options,
                'commands' => [
                    \App\Console\BootstrapCommand::class
                ],
                'apiHost' => $apiHost,
            ]);
        }
    ]);
};
