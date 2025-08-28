<?php

namespace App\Traits;

use App\Models\OrderItem;

trait HasOrderTotal
{
    /**
     * Calcula el total de la orden sumando cantidad * precio de cada item
     */
    public function calculateTotal(): float
    {
        return $this->items->sum(function (OrderItem $item) {
            return $item->quantity * $item->price;
        });
    }
}
