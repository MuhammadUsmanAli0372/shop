<?php

declare(strict_types=1);

namespace Domains\Customer\Model;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Domains\Customer\Model\Concerns\HasUuid;
use Domains\Customer\Models\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasUuid;
    use Notifiable;
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
