<?php
require 'vendor/autoload.php';

use Aws\DynamoDb\DynamoDbClient;

function getDynamoDbClient() {
    $options = [
        'region'  => 'eu-west-1',
        'version' => 'latest',
    ];
    if($_ENV["SERVERLESS_STAGE"] === "local") {
        $options['endpoint'] = 'http://dynamodb:8000';
        $options['credentials'] = [
           'key' => 'local',
           'secret' => 'local',
        ];
    }
    return new DynamoDbClient($options);
}

$client = getDynamoDbClient();
var_dump($client->listTables()->toArray()["TableNames"]);


