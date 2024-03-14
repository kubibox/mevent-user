<?php

declare(strict_types=1);

namespace App\Shared\Criteria\Orders;

enum OrderType: string
{
    case ORDER_DESC = 'desc';
    case ORDER_ASC = 'asc';

    case NONE = '';

    public function isNone(): bool
    {
        return $this === OrderType::NONE;
    }
}
