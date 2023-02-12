<?php

namespace App\Application\Actions\Api\Elephpant;

use App\Application\Actions\Action;
use App\Domain\Elephpant\Elephpant;
use App\Domain\Elephpant\ElephpantRepositoryInterface;
use App\Infrastructure\Persistence\Elephpant\DynamoDBElephpantRepository;
use Aws\S3\S3Client;
use Ramsey\Uuid\Uuid;
use Slim\Psr7\Response;

class CreateElephpantAction extends ElephpantApiAction
{
    protected function action(): Response
    {
        $data = $this->request->getParsedBody();

        if(is_null($data) || !array_key_exists("name", $data) || !array_key_exists("description", $data)) {
            return $this->respondWithData(["error" => "Missing name or description"], 400);
        }

        $id = Uuid::uuid4()->toString();
        $createdAt = time();
        $processed = false;
        $elephpant = new Elephpant(
            $id,
            $createdAt,
            $data["name"],
            $data["description"],
            $processed
        );

        /**
         * @var DynamoDBElephpantRepository $repository
         */
        $this->elephpantRepository->save($elephpant);

        $filePrefix = "full/" . $id . "/";
        $s3Settings = $this->settings->get("s3");
        $formInputs = ['acl' => 'public-read'];
        $options = [
            ['acl' => 'public-read'],
            ['bucket' => $s3Settings["bucketName"]],
            ['starts-with', '$key',  $filePrefix],
            ["starts-with", '$success_action_redirect', ""]
        ];

        $expires = '+2 hours';

        $postObject = new \Aws\S3\PostObjectV4(
            $this->s3Client,
            $s3Settings["bucketName"],
            $formInputs,
            $options,
            $expires
        );

        // Override host if we are running locally
        $attributes = $postObject->getFormAttributes();
        if($this->settings->get('environment') === 'local') {
            $attributes['action'] = str_replace('localstack', 'localhost', $attributes['action']);
        }

        return $this->respondWithData([
            "imageUploadAttributes" => $attributes,
            "imageUploadInputs" => $postObject->getFormInputs(),
            "filePrefix" => $filePrefix,
        ]);
    }
}