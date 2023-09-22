<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parcel extends Model
{
    use HasFactory;

    protected $table = 'parcels';

    protected $fillable = [
        'items',
        'otp',
        'weight',
        'volume',
        'description',
        'parcel_code',
        'price',
        'user_id',
        'senders',
        'packages',
    ];

    protected $hidden = [];

        
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(Sender::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
    
    public function recipients(): BelongsToMany
    {
        return $this->BelongsToMany(Recipient::class, 'recipients');
    }
}
