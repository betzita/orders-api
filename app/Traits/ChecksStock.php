<?php

namespace App\Traits;

use App\Models\Product;

trait ChecksStock
{
    /**
     * Verifica si hay stock suficiente de un producto
     */
    public function hasStock(int $productId, int $quantity): bool
    {
        $product = Product::find($productId);
        return $product && $product->stock >= $quantity;
    }
}
