<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
