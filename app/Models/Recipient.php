<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipient extends Model
{
    use HasFactory;

    protected $table = 'recipients';

    protected $fillable = [
        'parcel_id',
        'receive_id',
    ];

    
    public function parcels(): BelongsTo
    {
        return $this->belongsTo(Parcel::class);
    }

    public function receives(): BelongsTo
    {
        return $this->belongsTo(Receive::class);
    }
}
