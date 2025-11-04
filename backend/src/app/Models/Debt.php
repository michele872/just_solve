<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Debt extends Model
{
    use hasFactory;

    protected $fillable = [
        'external_id',
        'amount',
        'days_overdue',
        'status',
        'last_action',
        'last_action_at',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function actions()
    {
        return $this->hasMany(DebtAction::class);
    }

}
