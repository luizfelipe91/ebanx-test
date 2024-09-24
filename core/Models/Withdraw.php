<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'origin'
    ];

    function account()
    {
        return $this->belongsTo(Account::class, 'origin');
    }
}
