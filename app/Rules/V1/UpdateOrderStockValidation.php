<?php

namespace App\Rules\V1;

use App\Models\Order;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateOrderStockValidation implements ValidationRule
{
    public function __construct(
        protected Order $order,
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) {
            $fail(__('The Order products must be an array.'));

            return;
        }

        $order = Order::findOrFail($this->order->id)?->load('products');

        foreach ($value as $product) {
            if (! isset($product['id']) || ! isset($product['quantity'])) {
                $fail(__('Each product must have an ID and quantity.'));
                return;
            }

            $productId = $product['id'];
            $dbProduct = Product::find($productId);
            if (! $dbProduct) {
                $fail(__('Product with ID :product_id does not exist.', ['product_id' => $product['id']]));
                return;
            }

            $newQuantity = $product['quantity'];
            $currentQuantity = $order->products->find($productId)->pivot->quantity ?? 0;
            if ($newQuantity > $currentQuantity) {
                $stockDiff = $newQuantity - $currentQuantity;
                if ($dbProduct->stock < $stockDiff) {
                    $fail(__('Insufficient stock for product (:product_name). Current stock: :product_stock.', ['product_name' => $dbProduct->name, 'product_stock' => $dbProduct->stock]));
                    return;
                }
            }
        }
    }
}
