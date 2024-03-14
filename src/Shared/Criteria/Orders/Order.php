<?php

declare(strict_types=1);

namespace App\Shared\Criteria\Orders;

use JsonSerializable;

class Order implements JsonSerializable
{
    /**
     * @param OrderBy $by
     * @param OrderType $type
     */
    public function __construct(private readonly OrderBy $by, private readonly OrderType $type)
    {

    }

    /**
     * @param string|null $by
     * @param string|null $type
     * @return Order
     */
    public static function createFromValues(?string $by, ?string $type): Order
    {
        return $by === null ? self::none() : new Order(new OrderBy($by), OrderType::tryFrom($type) ?: OrderType::NONE);
    }

    /**
     * @return Order
     */
    public static function none(): Order
    {
        return new Order(new OrderBy(''), OrderType::NONE);
    }

    /**
     * @return bool
     */
    public function isNone(): bool
    {
        return $this->orderType()->isNone();
    }

    /**
     * @return OrderBy
     */
    public function orderBy(): OrderBy
    {
        return $this->by;
    }

    /**
     * @return OrderType
     */
    public function orderType(): OrderType
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'order_by' => $this->orderBy()->value(),
            'order_type' => $this->orderType()->value
        ];
    }
}
