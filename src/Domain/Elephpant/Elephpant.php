<?php

declare(strict_types=1);

namespace App\Domain\Elephpant;

use JsonSerializable;

class Elephpant implements JsonSerializable
{
    private string $id;

    private int $createdAt;

    private string $name;

    private string $description;

    private bool $processed;

    public function  __construct(string $id, int $createdAt, string $name, string $description, bool $processed)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->name = $name;
        $this->description = $description;
        $this->processed = $processed;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function isProcessed(): bool
    {
        return $this->processed;
    }

    public function setProcessed(bool $processed): self
    {
        $this->processed = $processed;
        return $this;
    }

    #[\ReturnTypeWillChange]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt,
            'name' => $this->name,
            'description' => $this->description,
            'processed' => $this->processed,
        ];
    }
}
