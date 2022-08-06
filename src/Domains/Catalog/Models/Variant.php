<?php

declare(strict_types=1);

namespace Domains\Catalog\Models;

use Database\Factories\VariantFactory;
use Domains\Shared\Models\Concerns\HasKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasKey;
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'cost',
        'retail',
        'height',
        'width',
        'length',
        'weight',
        'active',
        'shippable',
        'product_id'
    ];

    protected $cast = [
        'active' => 'boolean',
        'shippable' => 'boolean',
    ];

    protected static function newFactory(): Factory
    {
        return VariantFactory::new();
    }
}
