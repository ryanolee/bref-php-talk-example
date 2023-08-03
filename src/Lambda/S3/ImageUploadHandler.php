<?php

namespace App\Lambda\S3;

use App\Domain\Elephpant\ElephpantRepositoryInterface;
use App\Factory\ContainerFactory;
use App\Infrastructure\Persistence\Elephpant\DynamoDBElephpantRepository;
use Aws\S3\S3Client;
use Bref\Context\Context;
use Bref\Event\S3\S3Record;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Bref\Event\S3\S3Event;
use Bref\Event\S3\S3Handler;

class ImageUploadHandler extends S3Handler
{
    /**
     * Stub to make context optional
     */
    protected function getContainer(): ContainerInterface
    {
        return ContainerFactory::createInstance();
    }

    public function handleS3(S3Event $event, Context $context): void
    {
        $container = $this->getContainer();
        /** @var LoggerInterface $logger */
        $logger = $container->get(LoggerInterface::class);
        /** @var S3Client $s3Client */
        $s3Client = $container->get(S3Client::class);
        /** @var DynamoDBElephpantRepository $elephpantRepository */
        $elephpantRepository = $container->get(ElephpantRepositoryInterface::class);
        $logger->info('Received event' . serialize($event->getRecords()));

        foreach( $event->getRecords() as $record){
            /** @var S3Record $record  */
            $bucket = $record->getBucket();
            $object = $record->getObject();



            if(str_contains($object->getKey(), "thumbnail")){
                $logger->info("Not processing event for thumbnail image");
                continue;
            }

            $elephpantId = $this->getUuidv4FromKey($object->getKey());
            $localFilePath = "/tmp/$elephpantId.png";
            $logger->info("Bucket:" . $bucket->getName() . ", objectPath: ". $object->getKey() . ", Save Path $localFilePath");
            if(!$elephpantId){
                $logger->warning("No elephpant ID found... Skipping!");
                continue;
            }

            $elephpant = $elephpantRepository->findElephpantOfId($elephpantId);

            if(!$elephpant){
                $logger->warning("No elephpant found for ID $elephpantId ... Skipping!");
                continue;
            }

            $logger->info("Found elephpant $elephpantId. Processing Image!");

            $s3Client->getObject([
                "Bucket" => $bucket->getName(),
                "Key" => $object->getKey(),
                "SaveAs" => $localFilePath
            ]);

            $logger->info("Downloaded file to $localFilePath from ".  $bucket->getName() . "/" . $object->getKey());

            $image = new \Imagick($localFilePath);
            $processedImagePath = "/tmp/".$elephpantId."_thumbnail.png";
            $image->scaleImage(320, 180, true);
            $image->writeImage($processedImagePath);

            $logger->info("Resized Image");

            $targetPath = "thumbnail/$elephpantId/image.png";
            $s3Client->putObject([
                "Bucket" => $bucket->getName(),
                "Key" => $targetPath,
                "SourceFile" => $processedImagePath
            ]);

            $logger->info("Uploaded Image back to bucket under $targetPath!");
        }
    }

    protected function getUuidv4FromKey(string $key): ?string {
        preg_match("/(?<uuidv4>\w{8}-\w{4}-\w{4}-\w{4}-\w{12})/", $key, $matches);
        return array_key_exists('uuidv4', $matches) ? $matches['uuidv4'] : null;
    }
}

return new ImageUploadHandler();