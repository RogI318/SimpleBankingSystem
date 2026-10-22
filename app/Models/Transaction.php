<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\AccountObserver;

#[ObservedBy([AccountObserver::class])]
class Transaction extends Model
{
    protected $fillable = [
        'account_id',
        'type',
        'amount',
        'reference_number',
        'notes',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
