<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Receive extends Model
{
    use HasFactory;

    protected $table = 'receives';

    
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'email',
    ];

    protected $hidden= [];

    
    public function recipients(): BelongsToMany
    {
        return $this->BelongsToMany(Recipient::class, 'recipients');
    }
}
