<?php

namespace App\Infrastructure\Persistence\Elephpant;


use App\Application\Settings\SettingsInterface;
use App\Domain\Elephpant\Elephpant;
use App\Domain\Elephpant\ElephpantRepositoryInterface as ElephpantRepositoryInterface;
use Aws\DynamoDb\DynamoDbClient;
use Aws\S3\S3Client;

class DynamoDBElephpantRepository implements ElephpantRepositoryInterface
{
    private $client;
    private $s3Client;

    private $settings;
    const TABLE_NAME = 'elephpants-6';

    public function __construct(DynamoDbClient $client, S3Client $s3Client, SettingsInterface $settings)
    {
        $this->client = $client;
        $this->s3Client = $s3Client;
        $this->settings = $settings;
    }

    public function findAll($limit = 10): array
    {
        $queryResults = iterator_to_array($this->client->scan([
            'TableName' => self::TABLE_NAME,
            'Limit' => $limit,

        ])->getIterator());

        return array_map(function ($item) {
            return $this->mapItemToElephpant($item);
        }, $queryResults['Items']);
    }

    public function findElephpantOfId(string $id): ?Elephpant
    {
        return new Elephpant( 1, 2, 3, 4, 5 );
    }

    public function findElephpantImageOfId($id): ?string {
        $s3Settings = $this->settings->get("s3");
        $path = "thumbnail/$id/image.png";

        return $s3Settings["bucketPath"] . $path;
    }

    public function save(Elephpant $elephpant): void
    {
        $this->client->putItem([
            'TableName' => self::TABLE_NAME,
            'Item' => [
                'id' => ['S' => $elephpant->getId()],
                'name' => ['S' => $elephpant->getName()],
                'description' => ['S' => $elephpant->getDescription()],
                'createdAt' => ['N' => (string)$elephpant->getCreatedAt()],
                'processed' => ['BOOL' => $elephpant->isProcessed()],
            ]
        ]);
    }

    protected function mapItemToElephpant(array $item): Elephpant
    {
        return new Elephpant(
            $item['id']['S'],
            $item['createdAt']['N'],
            $item['name']['S'],
            $item['description']['S'],
            $item['processed']['BOOL']
        );
    }
}