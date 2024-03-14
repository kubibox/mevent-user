<?php

declare(strict_types=1);

namespace App\Shared\Criteria\Filters;

class FilterValue
{
    /**
     * @param mixed $value
     */
    public function __construct(private readonly mixed $value)
    {
    }

    /**
     * @return mixed
     */
    public function value(): mixed
    {
        return $this->value;
    }
}
