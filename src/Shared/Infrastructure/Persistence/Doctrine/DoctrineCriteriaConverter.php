<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use App\Shared\Criteria\Criteria;
use App\Shared\Criteria\Filters\Filter;
use App\Shared\Criteria\Filters\FilterField;
use App\Shared\Criteria\Orders\OrderBy;
use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\Common\Collections\Expr\CompositeExpression;

final class DoctrineCriteriaConverter
{
    /**
     * @param Criteria $criteria
     * @param array $criteriaToDoctrineFields
     * @param array $hydrators
     */
    public function __construct(
        private readonly Criteria $criteria,
        private readonly array $criteriaToDoctrineFields = [],
        private readonly array $hydrators = []
    ) {
    }

    /**
     * @param Criteria $criteria
     * @param array $criteriaToDoctrineFields
     * @param array $hydrators
     * @return DoctrineCriteria
     */
    public static function convert(
        Criteria $criteria,
        array $criteriaToDoctrineFields = [],
        array $hydrators = []
    ): DoctrineCriteria {
        $converter = new self($criteria, $criteriaToDoctrineFields, $hydrators);

        return $converter->convertToDoctrineCriteria();
    }

    /**
     * @return DoctrineCriteria
     */
    private function convertToDoctrineCriteria(): DoctrineCriteria
    {
        return new DoctrineCriteria(
            $this->buildExpression($this->criteria),
            $this->formatOrder($this->criteria),
            $this->criteria->offset(),
            $this->criteria->limit()
        );
    }

    /**
     * @param Criteria $criteria
     *
     * @return CompositeExpression|null
     */
    private function buildExpression(Criteria $criteria): ?CompositeExpression
    {
        if ($criteria->hasFilters()) {
            return new CompositeExpression(
                CompositeExpression::TYPE_AND,
                array_map($this->buildComparison(), $criteria->plainFilters())
            );
        }

        return null;
    }

    /**
     * @return callable
     */
    private function buildComparison(): callable
    {
        return function (Filter $filter): Comparison {
            $field = $this->mapFieldValue($filter->field());
            $value = $this->existsHydratorFor($field)
                ? $this->hydrate($field, $filter->value()->value())
                : $filter->value()->value();

            return new Comparison($field, $filter->operator()->value, $value);
        };
    }

    /**
     * @param FilterField $field
     *
     * @return mixed|string
     */
    private function mapFieldValue(FilterField $field)
    {
        return array_key_exists($field->value(), $this->criteriaToDoctrineFields)
            ? $this->criteriaToDoctrineFields[$field->value()]
            : $field->value();
    }

    /**
     * @param Criteria $criteria
     *
     * @return array|null
     */
    private function formatOrder(Criteria $criteria): ?array
    {
        if (!$criteria->hasOrder()) {
            return null;
        }

        return [$this->mapOrderBy($criteria->order()->orderBy()) => $criteria->order()->orderType()];
    }

    /**
     * @param OrderBy $field
     *
     * @return mixed|string
     */
    private function mapOrderBy(OrderBy $field)
    {
        return array_key_exists($field->value(), $this->criteriaToDoctrineFields)
            ? $this->criteriaToDoctrineFields[$field->value()]
            : $field->value();
    }

    /**
     * @param $field
     *
     * @return bool
     */
    private function existsHydratorFor($field): bool
    {
        return array_key_exists($field, $this->hydrators);
    }

    /**
     * @param $field
     * @param string $value
     *
     * @return mixed
     */
    private function hydrate($field, string $value)
    {
        return $this->hydrators[$field]($value);
    }
}
