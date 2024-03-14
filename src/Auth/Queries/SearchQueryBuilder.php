<?php

declare(strict_types=1);

namespace App\Auth\Queries;

use App\Shared\Queries\QueryBuilder;
use Illuminate\Database\Query\Builder;

class SearchQueryBuilder extends QueryBuilder
{
    public function search(string $username): Builder
    {
        return $this->builder()->where('email', 'like', "%$username%");
    }

    public function table(): string
    {
        return 'users';
    }

    public function build(Builder $builder): Builder
    {
        // TODO: Implement build() method.
    }
}
