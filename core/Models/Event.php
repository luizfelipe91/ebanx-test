<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'amount',
        'account_id'
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    // Relationships

    function account()
    {
        return $this->belongsTo(Account::class);
    }
}
