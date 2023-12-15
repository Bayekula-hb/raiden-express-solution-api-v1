<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ColiPackage extends Model
{
    use HasFactory;

    protected $table = 'coli_packages';

    protected $fillable = [
        'items',
        'otp',
        'weight',
        'volume',
        'description',
        'parcel_code',
        'price',
        'user_id',
        'sender',
        'receives',
        'destination',
        'package_id',
        'customer_id',
        'type_transaction_id',
    ];

    protected $hidden = [];

        
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
    
    public function type_transaction(): BelongsTo
    {
        return $this->belongsTo(TypeTransaction::class);
    }
}
