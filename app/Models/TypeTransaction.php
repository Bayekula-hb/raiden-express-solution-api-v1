<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
