<?php

declare(strict_types=1);

namespace Domains\Fulfilment\Models;

use Database\Factories\OrderFactory;
use Domains\Shared\Models\Concerns\HasKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasKey;
    use HasFactory;

    protected $fillable = [
        'key',
        'number',
        'state',
        'coupon',
        'intent_id',
        'total',
        'reduction',
        'user_id',
        'shipping_id',
        'billing_id',
        'completed_at',
        'cancelled_at',
    ];

    protected $cast = [
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function billing(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function lineItems(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    protected static function newFactory(): Factory
    {
        return OrderFactory::new();
    }
}
