<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sender extends Model
{
    use HasFactory;

    protected $table = 'senders';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'physical_address',
        'email',
    ];
    
    protected $hidden = [];

    
    public function parcels(): HasMany
    {
        return $this->HasMany(Parcel::class);
    }
}
