<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\CartItemFactory;
use Domains\Shared\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CartItem extends Model
{
    use HasUuid;
    use HasFactory;

    protected $fillable = [
        'uuid',
        'quantity',
        'purchasable_id',
        'purchasable_type',
        'cart_id',
    ];

    protected $cast = [
        'quantity' => 'int',
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
