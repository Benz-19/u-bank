<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'balance_after',
        'currency',
        'senderAcc_no',
        'recipientAcc_no',
        'status',
        'recipient_id',
        'reference',
        'description'
    ];
}
