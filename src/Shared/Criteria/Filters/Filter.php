<?php

declare(strict_types=1);

namespace App\Shared\Criteria\Filters;

use JsonSerializable;

class Filter implements JsonSerializable
{
    private const DEFAULT_FILTER_OPERATOR = '=';

    /**
     * @param FilterField $field
     * @param FilterValue $value
     * @param FilterOperator|null $operator
     */
    public function __construct(
        private readonly FilterField $field,
        private readonly FilterValue $value,
        private readonly ?FilterOperator $operator = null,
    ) {
    }

    /**
     * @example createFromArray(['field' => 'id', 'value' = 1])
     * @param array $filter
     * @return Filter
     */
    public static function createFromArray(array $filter): Filter
    {
        return new Filter(
            new FilterField($filter['field'] ?? ''),
            new FilterValue($filter['value'] ?? null)
        );
    }

    /**
     * @return FilterField
     */
    public function field(): FilterField
    {
        return $this->field;
    }

    /**
     * @return FilterValue
     */
    public function value(): FilterValue
    {
        return $this->value;
    }

    /**
     * @return FilterOperator
     */
    public function operator(): FilterOperator
    {
        return ($this->operator ?: FilterOperator::tryFrom(self::DEFAULT_FILTER_OPERATOR));
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'filed' => $this->field()->value(),
            'value' => $this->value()->value(),
        ];
    }
}
