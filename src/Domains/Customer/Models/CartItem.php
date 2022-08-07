<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\CartItemFactory;
use Domains\Shared\Models\Concerns\HasKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CartItem extends Model
{
    use HasKey;
    use HasFactory;

    protected $fillable = [
        'key',
        'purchasable_id',
        'purchasable_type',
        'cart_id'
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function purchasable(): MorphTo
    {
    return $this->morphTo();
    }

    protected static function newFactory(): Factory
    {
        return CartItemFactory::new();
    }
}