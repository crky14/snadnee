<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'word_id', 'sender_account', 'receiver_account', 'price', 'currency', 'datetime', 'KS', 'VS', 'SS'
    ];


    /**
     * Get the word record associated with transaction.
     */
    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
