<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{


    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id'
    ];

    function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    function events()
    {
        return $this->hasMany(Event::class);
    }
}
