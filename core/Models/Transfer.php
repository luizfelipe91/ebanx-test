<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'origin',
        'destination'
    ];

    function account()
    {
        return $this->belongsTo(Account::class, 'origin');
    }

    function destinationAccount()
    {
        return $this->belongsTo(Account::class, 'destination');
    }
}
