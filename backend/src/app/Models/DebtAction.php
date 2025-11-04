<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DebtAction extends Model
{
    use hasFactory;

    protected $fillable = [
        'debt_id',
        'action',
        'reason',
    ];

    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }
}
