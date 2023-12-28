<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeTransaction extends Model
{
    use HasFactory;
    /**
     * The table associated with model.
     *
     * @var string
     */
    protected $table = 'type_transactions';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_type',
        'description_type',
        'percentage',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
    
    // public function users(): HasMany
    // {
    //     return $this->HasMany(User::class);
    // }
    public function coli_packagesCustomer(): HasMany
    {
        return $this->HasMany(ColiPackage::class);
    }

    public function moneyTransCustomer(): HasMany
    {
        return $this->HasMany(MoneyTrans::class);
    }
}
