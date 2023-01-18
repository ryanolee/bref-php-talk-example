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
                'bucketName' => getenv('ELEPHANTS_BUCKET'),
            ];

            $s3Options["bucketPath"] = "https://s3.". $s3Options['region'] . ".amazonaws.com/" . $s3Options["bucketName"] . "/";

            if(getenv("SERVERLESS_STAGE") && getenv("SERVERLESS_STAGE") === "local") {
                // Local DynamoDB
                $dynamoDBOptions['endpoint'] = 'http://localstack:4566';
                $dynamoDBOptions['credentials'] = [
                    'key' => 'local',
                    'secret' => 'local',
                ];

                // Local S3
                $s3Options['endpoint'] = 'http://localstack:4566';
                $s3Options['credentials'] = [
                    'key' => 'local',
                    'secret' => 'local',
                ];

                $s3Options["use_path_style_endpoint"] = true;
                $s3Options["bucketName"] = "elephpants-5";
                $s3Options["bucketPath"] =  'http://localhost:4566/' . $s3Options["bucketName"] . "/";
            }

            return new Settings([
                'environment' => getenv("SERVERLESS_STAGE") ?? "production",
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
                ]
            ]);
        }
    ]);
};
