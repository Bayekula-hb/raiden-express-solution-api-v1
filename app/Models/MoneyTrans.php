<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MoneyTrans extends Model
{
    use HasFactory;

    protected $table = 'money_trans';

    protected $fillable = [
        'otp',
        'costs',
        'amount_send',
        'user_id',
        'receives',
        'step',
        'destination',
        'customer_id',
        'type_transaction_id',
        'routing_trans_money_id',
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
    
    public function type_transaction(): BelongsTo
    {
        return $this->belongsTo(TypeTransaction::class);
    }
    
    public function routing_trans_money(): BelongsTo
    {
        return $this->belongsTo(RoutingTransMoney::class);
    }
}
