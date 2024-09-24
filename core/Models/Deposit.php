<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'destination'
    ];

    function account()
    {
        return $this->belongsTo(Account::class, 'destination');
    }
}
