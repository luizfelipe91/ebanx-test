<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{

    use HasFactory;


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
