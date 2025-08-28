<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Jobs\UpdateProductStock;
use App\Traits\HasOrderTotal;
use App\Traits\ChecksStock;
use App\Traits\Notifies;
use Illuminate\Support\Facades\Cache;
use Exception;

class OrderService
{
    use HasOrderTotal,ChecksStock,Notifies;

    public function createOrder(array $data): Order
    {
        foreach ($data['items'] as $item) {
            if (!$this->hasStock($item['product_id'], $item['quantity'])) {
                throw new Exception("Producto sin stock: {$item['product_id']}");
            }
        }

        // Crear la orden
        $order = Order::create([
            'client_id'        => $data['client_id'],
            'shipping_address' => $data['shipping_address'],
            'billing_address'  => $data['billing_address'],
            'total'            => 0,
        ]);

        // Asociar items
        foreach ($data['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            $order->items()->create([
                'product_id' => $product->id,
                'quantity'   => $item['quantity'],
                'price'      => $product->price,
            ]);
        }

        // Recalcular total
        $order->total = $order->calculateTotal();
        $order->save();

        // Limpiar cache y ejecutar Jobs
        Cache::forget('orders_all');
        Cache::forget("client_{$order->client_id}");

        $this->notifyCustomer($order);
        $this->notifyLogistics($order, ['logistics@example.com']);

        UpdateProductStock::dispatch($order->id);

        return $order;
    }
}
