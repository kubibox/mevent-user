<?php

declare(strict_types=1);

namespace App\Shared\Criteria\Filters;

class Filters
{
    /**
     * @var Filter[]
     */
    private array $filters = [];

    /**
     * @param Filter ...$filters
     *
     * @return void
     */
    public function addFilter(Filter ...$filters): void
    {
        foreach ($filters as $filter) {
            $this->filters[] = $filter;
        }
    }

    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return $this->filters;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->filters);
    }
}
