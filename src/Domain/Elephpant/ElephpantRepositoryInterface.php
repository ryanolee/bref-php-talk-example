<?php

namespace App\Domain\Elephpant;

interface ElephpantRepositoryInterface
{
    public function findAll(): array;

    public function findElephpantOfId(int $id): ?Elephpant;

    public function save(Elephpant $elephpant): void;
}