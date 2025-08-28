<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear clientes
        $clients = \App\Models\Client::factory(5)->create();
        $products = \App\Models\Product::factory(10)->create();

        \App\Models\Order::factory(5)
            ->state(function () use ($clients) {
                return ['client_id' => $clients->random()->id];
            })
            ->has(
                \App\Models\OrderItem::factory()
                    ->count(3)
                    ->state(function () use ($products) {
                        $product = $products->random();
                        return [
                            'product_id' => $product->id,
                            'price' => $product->price,
                        ];
                    }),
                'items'   
            )
            ->create()
            ->each(function ($order) {
                $total = $order->items->sum(fn($item) => $item->price * $item->quantity);
                $order->update(['total' => $total]);
            });
    }
}
