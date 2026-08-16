<?php

namespace App\Rules\V1;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CreateOrderStockValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) {
            $fail(__('The Order products must be an array.'));
            return;
        }

        foreach ($value as $product) {
            if (! isset($product['id']) || ! isset($product['quantity'])) {
                $fail(__('Each product must have an ID and quantity.'));

                return;
            }

            $dbProduct = Product::find($product['id']);

            if (! $dbProduct) {
                $fail(__('Product with ID :product_id does not exist.', ['product_id' => $product['id']]));
                return;
            }

            if ($dbProduct->stock < $product['quantity']) {
                $fail(__('Insufficient stock for product (:product_name). Current stock: :product_stock.', ['product_name' => $dbProduct->name, 'product_stock' => $dbProduct->stock]));
                return;
            }
        }
    }
}
