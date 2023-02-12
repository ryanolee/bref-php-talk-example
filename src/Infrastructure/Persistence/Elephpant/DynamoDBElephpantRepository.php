<?php

namespace App\Infrastructure\Persistence\Elephpant;


use App\Domain\Elephpant\Elephpant;
use App\Domain\Elephpant\ElephpantRepositoryInterface as ElephpantRepositoryInterface;
use Aws\DynamoDb\DynamoDbClient;

class DynamoDBElephpantRepository implements ElephpantRepositoryInterface
{
    private $client;
    const TABLE_NAME = 'elephpants-3';

    public function __construct(DynamoDbClient $client)
    {
        $this->client = $client;
    }

    public function findAll(): array
    {
        return [];
    }

    public function findElephpantOfId(int $id): ?Elephpant
    {
        return new Elephpant( 1, 2, 3, 4, 5 );
    }

    public function save(Elephpant $elephpant): void
    {
        $this->client->putItem([
            'TableName' => self::TABLE_NAME,
            'Item' => [
                'id' => ['N' => $elephpant->getId()],
                'name' => ['S' => $elephpant->getName()],
                'description' => ['S' => $elephpant->getDescription()],
                'createdAt' => ['N' => $elephpant->getCreatedAt()],
            ]
        ]);
    }
}