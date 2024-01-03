<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoutingTransMoney extends Model
{
    use HasFactory;

    protected $table = 'routing_trans_moneys';

    protected $fillable = [
        'name_routing_trans',
        'description_routing_trans',
        'percentage_routing_trans',
    ];

    protected $hidden = [];     

    public function coli_packages(): HasMany
    {
        return $this->HasMany(ColiPackage::class, 'routing_trans_money_id', 'id');
    }
}
