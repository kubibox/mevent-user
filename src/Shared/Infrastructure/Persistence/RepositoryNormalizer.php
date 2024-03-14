<?php

namespace App\Shared\Infrastructure\Persistence;

use Illuminate\Support\Collection;
use stdClass;

trait RepositoryNormalizer
{
    protected function normalizeRows(array $rows): array
    {
        return array_map($this->normalize(...), $rows);
    }

    protected function normalizeCollections(Collection $collection): array
    {
        return $collection->map(function (array|stdClass $row): mixed {
            if (is_object($row)) {
                $row = (array)$row;
            }

            return $this->normalize($row);
        })->toArray();
    }
}
