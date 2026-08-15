<?php

namespace App\Services\V1;

use App\Http\Requests\Api\V1\BaseOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrdersService
{
    public function createOrderHandleProducts(BaseOrderRequest $request): Order
    {
        return DB::transaction(function () use ($request) {
            $order = Order::create($request->mappedAttributes());
            $incomingProducts = collect($request->input('data.relationships.products', []))->keyBy('id');

            foreach ($incomingProducts as $productId => $productData) {
                $quantity = $productData['quantity'];
                $price = $productData['price'];
                $lockedProduct = Product::where('id', $productId)->lockForUpdate()->first();
                $order->products()->attach($productId, ['quantity' => $quantity, 'price' => $price]);
                $lockedProduct->decrement('stock', $quantity);
            }

            return $order;
        });
    }

    public function updateOrderHandleProducts(BaseOrderRequest $request, Order $order): void
    {
        DB::transaction(function () use ($request, $order) {
            $order->lockForUpdate();
            $order->update($request->mappedAttributes());
            $incomingProducts = collect($request->input('data.relationships.products', []))->keyBy('id');
            $currentProducts = $order->products()->lockForUpdate()->get()->keyBy('id');
            foreach ($currentProducts as $productId => $product) {
                if (! $incomingProducts->has($productId)) {
                    $lockedProduct = Product::where('id', $productId)->lockForUpdate()->first();
                    $lockedProduct->increment('stock', $product->pivot->quantity);
                    $order->products()->detach($productId);
                }
            }

            foreach ($incomingProducts as $productId => $productData) {
                $quantity = $productData['quantity'];
                $price = $productData['price'];

                $lockedProduct = Product::where('id', $productId)->lockForUpdate()->first();

                if ($currentProducts->has($productId)) {
                    $currentQuantity = $currentProducts[$productId]->pivot->quantity;
                    $quantityDifference = $quantity - $currentQuantity;

                    if ($quantityDifference > 0) {
                        $lockedProduct->decrement('stock', $quantityDifference);
                    } elseif ($quantityDifference < 0) {
                        $lockedProduct->increment('stock', abs($quantityDifference));
                    }

                    $order->products()->updateExistingPivot($productId, ['quantity' => $quantity, 'price' => $price]);
                } else {
                    $order->products()->attach($productId, ['quantity' => $quantity, 'price' => $price]);
                    $lockedProduct->decrement('stock', $quantity);
                }
            }
        });
    }

    public function deleteOrderHandleProducts(Order $order): void
    {
        DB::transaction(function () use ($order) {
            $currentProducts = $order->products()->lockForUpdate()->get()->keyBy('id');
            $order->products()->detach();
            foreach ($currentProducts as $productId => $product) {
                $lockedProduct = Product::where('id', $productId)->lockForUpdate()->first();
                $lockedProduct->increment('stock', $product->pivot->quantity);
            }
            $order->delete();
        });
    }
}
