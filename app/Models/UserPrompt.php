<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPrompt extends Model
{
    protected $table = 'user_prompts';

    protected $fillable = [
        'user_id',
        'prompt',
        'response',
        'subscription_type',
    ];

    /**
     * Get the user that owns the prompt.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

