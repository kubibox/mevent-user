<?php

declare(strict_types=1);

namespace App\Shared\Domain;

interface RepositoryInterface
{
    public function all(): array;

    public function find(int $id): object;

    public function findByParams(object $params): array;

    public function findOneByParams(object $params): array;
}
