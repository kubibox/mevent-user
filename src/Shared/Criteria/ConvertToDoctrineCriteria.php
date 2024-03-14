<?php

declare(strict_types=1);

namespace App\Shared\Criteria;

use App\Shared\Criteria\Filters\FilterOperator;
use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
trait ConvertToDoctrineCriteria
{
    /**
     * @param Criteria $criteria
     *
     * @return DoctrineCriteria
     */
    protected function convertToDoctrineCriteria(Criteria $criteria): DoctrineCriteria
    {
        $expressionBuilder = DoctrineCriteria::expr();

        $filters = $criteria->filters()->filters();

        $doctrineCriteria = DoctrineCriteria::create();

        foreach ($filters as $filter) {
            match ($filter->operator()) {
                FilterOperator::GT => $doctrineCriteria->andWhere($expressionBuilder->gt($filter->field()->value(), $filter->value()->value())),
                FilterOperator::LT => $doctrineCriteria->andWhere($expressionBuilder->lt($filter->field()->value(), $filter->value()->value())),
                FilterOperator::EQUAL => $doctrineCriteria->andWhere($expressionBuilder->eq($filter->field()->value(), $filter->value()->value())),
                FilterOperator::NOT_EQUAL => $doctrineCriteria->andWhere($expressionBuilder->neq($filter->field()->value(), $filter->value()->value())),
                FilterOperator::CONTAINS => $doctrineCriteria->andWhere($expressionBuilder->in($filter->field()->value(), $filter->value()->value())),
                FilterOperator::NOT_CONTAINS => $doctrineCriteria->andWhere($expressionBuilder->notIn($filter->field()->value(), $filter->value()->value()))
            };
        }

        return $doctrineCriteria;
    }
}
