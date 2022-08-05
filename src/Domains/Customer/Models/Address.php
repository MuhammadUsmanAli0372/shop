<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Database\Factories\AddressFactory;
use Domains\Customer\Models\User;
use Domains\Customer\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'billing',
        'user_id',
        'location_id'
    ];

    protected $cast = [
        'billing' => 'boolean',
    ];

    protected static function newFactory(): Factory
    {
        return AddressFactory::new();
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function sharedBilling(): HasMany
    {
        return $this->hasMany(
            related: User::class,
            foreignKey: 'billing_id'
        );
    }
}
