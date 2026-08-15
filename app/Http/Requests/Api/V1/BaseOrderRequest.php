<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseOrderRequest extends FormRequest
{
    public function mappedAttributes()
    {
        $attributeMap = [
            'data.attributes.name' => 'name',
            'data.attributes.description' => 'description',
            'data.attributes.status' => 'status',
            'data.attributes.date' => 'date',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updated_at',
            'data.attributes.user_id' => 'user_id',
        ];

        $attributesToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attributesToUpdate[$attribute] = $this->input($key);
            }
        }

        return $attributesToUpdate;
    }

    public function messages(): array
    {
        return [
            'data.attributes.user_id.required' => __('The user id field is required.'),
            'data.attributes.user_id.exists' => __('The selected user id is invalid.'),
            'data.attributes.name.required' => __('The name field is required.'),
            'data.attributes.name.string' => __('The name field must be a string.'),
            'data.attributes.description.required' => __('The description field is required.'),
            'data.attributes.description.string' => __('The description field must be a string.'),
            'data.attributes.status.required' => __('The status field is required.'),
            'data.attributes.status.string' => __('The status field must be a string.'),
            'data.attributes.status.in' => __('The status field must be one of: P, F, C.'),
            'data.attributes.date.required' => __('The date field is required.'),
            'data.attributes.date.date' => __('The date field must be a date.'),
            'data.relationships.products.required' => __('There must be at least one product in the order.'),
            'data.relationships.products.array' => __('The products must be grouped in an array.'),
            'data.relationships.products.*.id.required' => __('The products id field is required.'),
            'data.relationships.products.*.id.exists' => __('The selected products id is invalid.'),
            'data.relationships.products.*.quantity.required' => __('The products quantity field is required.'),
            'data.relationships.products.*.quantity.integer' => __('The products quantity field must be an integer.'),
            'data.relationships.products.*.quantity.min' => __('The products quantity field must be at least 1.'),
            'data.relationships.products.*.price.required' => __('The products price field is required.'),
            'data.relationships.products.*.price.numeric' => __('The products price field must be a number.'),
            'data.relationships.products.*.price.min' => __('The products price field must be at least 0.'),
        ];
    }
}
