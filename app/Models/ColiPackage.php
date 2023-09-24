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
        'packages',
    ];

    protected $hidden = [];

        
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
