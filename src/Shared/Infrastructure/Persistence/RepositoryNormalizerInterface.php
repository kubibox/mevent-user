<?php

namespace App\Shared\Infrastructure\Persistence;

interface RepositoryNormalizerInterface
{
    public function normalize(array $row): object;
}