<?php

declare(strict_types=1);

namespace App\Shared\Criteria;

use App\Shared\Criteria\Filters\Filters;
use App\Shared\Criteria\Orders\Order;
use JsonSerializable;

class Criteria implements JsonSerializable
{
    public function __construct(
        private readonly Filters $filters,
        private readonly Order $order,
        private readonly ?int $offset = null,
        private readonly ?int $limit = null
    ) {
    }

    /**
     * @return bool
     */
    public function hasFilters(): bool
    {
        return !$this->filters->isEmpty();
    }

    /**
     * @return bool
     */
    public function hasOrder(): bool
    {
        return !$this->order->isNone();
    }

    /**
     * @return array
     */
    public function plainFilters(): array
    {
        return $this->filters->filters();
    }

    /**
     * @return Filters
     */
    public function filters(): Filters
    {
        return $this->filters;
    }

    /**
     * @return Order
     */
    public function order(): Order
    {
        return $this->order;
    }

    /**
     * @return int|null
     */
    public function offset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return int|null
     */
    public function limit(): ?int
    {
        return $this->limit;
    }

    public function jsonSerialize(): array
    {
        return [
            'filters' => $this->filters,
            'order' => $this->order,
        ];
    }
}
