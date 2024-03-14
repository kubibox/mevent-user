<?php

declare(strict_types=1);

namespace App\Shared\Criteria\Filters;

enum FilterOperator: string
{
    case EQUAL = '=';
    case NOT_EQUAL = '!=';
    case GT = '>';
    case LT = '<';
    case CONTAINS = 'CONTAINS';
    case NOT_CONTAINS = 'NOT_CONTAINS';

    /**
     * @return bool
     */
    public function isContaining(): bool
    {
        return match($this->value) {
            FilterOperator::CONTAINS, FilterOperator::NOT_CONTAINS => true,
            default => false
        };
    }
}
