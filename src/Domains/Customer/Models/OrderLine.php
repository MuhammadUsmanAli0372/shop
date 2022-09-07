<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\OrderLineFactory;
use Domains\Shared\Models\Concerns\HasKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLine extends Model
{
    use HasKey;
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'description',
        'cost',
        'retail',
        'quantity',
        'purchasable_id',
        'purchasable_type',
        'order_id'

    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    protected $cast = [];

    protected static function newFactory(): Factory
    {
        return OrderLineFactory::new();
    }
}
