<?php

namespace App\Models;

use Database\Factories\OrderProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['order_id', 'product_id', 'quantity', 'price'])]
class OrderProduct extends Model
{
    /** @use HasFactory<OrderProductFactory> */
    use HasFactory;
}
