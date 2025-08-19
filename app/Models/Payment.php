<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';
    protected $fillable = [
        'amount',
        'client',
        'kind',
        'merchant',
        'ref',
        'status',
        'timestamp',
    ];

    /**
     * Get the user that owns the payment (by phone).
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'client', 'phone');
    }
}
