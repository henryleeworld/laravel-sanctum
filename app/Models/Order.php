<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'description', 'date', 'status', 'user_id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The products that belong to the order.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function scopeFilter(Builder $query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
