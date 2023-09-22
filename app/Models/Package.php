<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';
    
    protected $fillable = [
        'name_package',
        'destination_package',
        'description',
        'departure_date',
        'arrival_date',
    ];

    protected $hidden =[];

    public function users(): HasMany
    {
        return $this->HasMany(Parcel::class);
    }
}
