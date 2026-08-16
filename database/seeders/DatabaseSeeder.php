<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(5)->create();
        $products = Product::factory(50)->create();

        Order::factory(60)->recycle($users)
            ->create()->each(function ($order) use ($products) {
                $randomProducts = $products->random(rand(1, 10));

                $randomProducts->each(function ($product) use ($order) {
                    $quantity = rand(1, 7);
                    $order->products()->attach($product->id, ['quantity' => $quantity, 'price' => $product->price]);
                });
            }
            );
    }
}
