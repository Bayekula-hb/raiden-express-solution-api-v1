<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'email',
        'gender',
        'type_user_id',
        'password',
        'raiden_point',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function type_user(): BelongsTo
    {
        return $this->belongsTo(TypeUser::class);
    }
    
    public function parcels(): HasMany
    {
        return $this->HasMany(Parcel::class);
    }

    public function coli_packages(): HasMany
    {
        return $this->HasMany(ColiPackage::class, 'user_id', 'id');
    }

    public function coli_packagesCustomer(): HasMany
    {
        return $this->HasMany(ColiPackage::class, 'customer_id', 'id');
    }

    public function money_transUser(): HasMany
    {
        return $this->HasMany(MoneyTrans::class, 'user_id', 'id');
    }
    public function money_transCustomer(): HasMany
    {
        return $this->HasMany(MoneyTrans::class, 'customer_id', 'id');
    }
}
