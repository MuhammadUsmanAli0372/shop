<?php

declare(strict_types=1);

namespace Domains\Catalog\Models;

use Database\Factories\RangeFactory;
use Domains\Shared\Models\Concerns\HasKey;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Range extends Model
{
    use HasKey;
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'key',
        'name',
        'description',
        'active',
    ];

    protected $cast = [
        'active' => 'boolean',
    ];

    protected static function newFactory(): Factory
    {
        return RangeFactory::new();
    }
}
