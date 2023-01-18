<?php

namespace App\Domain\Elephpant;

interface ElephpantRepositoryInterface
{
    public function findAll(): array;

    public function findElephpantOfId(string $id): ?Elephpant;

    public function findElephpantImageOfId(string $id): ?string;

    public function save(Elephpant $elephpant): void;
}