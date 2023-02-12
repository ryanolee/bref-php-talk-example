<?php

namespace App\Lambda\API;

use App\Domain\Elephpant\Elephpant;
use App\Domain\Elephpant\ElephpantRepositoryInterface;
use App\Factory\ContainerFactory;
use App\Infrastructure\Persistence\Elephpant\DynamoDBElephpantRepository;
use Aws\S3\S3Client;
use Bref\Context\Context;
use Bref\Event\Handler;
use Nyholm\Psr7\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;

class CreateElephpantHandler implements Handler
{
    /**
     * Stub to make context optional
     */
    public function handle($event, ?Context $context = null): ResponseInterface
    {
        $container = $this->getContainer();
        $data = json_decode($event->getBody(), true);

        if(!array_key_exists("name", $data) || !array_key_exists("description", $data)) {
            return new Response(400, [], json_encode(["error" => "Missing name or description"]));
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
        $repository = $container->get(ElephpantRepositoryInterface::class);
        $repository->save($elephpant);

        /**
         * @var S3Client $s3Client
         */
        $s3Client = $container->get(S3Client::class);
        $bucket = 'elephpant-4';
        $formInputs = ['acl' => 'public-read'];
        $options = [
            'acl' => 'public-read',
            'bucket' => $bucket,
            'starts-with' => 'full/' . $id,
        ];

        $expires = '+2 hours';

        $postObject = new \Aws\S3\PostObjectV4(
            $s3Client,
            $bucket,
            $formInputs,
            $options,
            $expires
        );

        return new Response(200, [], json_encode([
            "imageUploadAttributes" => $postObject->getFormAttributes(),
            "imageUploadInputs" => $postObject->getFormInputs(),
        ]));
    }

    protected function getContainer(): ContainerInterface
    {
        return ContainerFactory::createInstance();
    }
}