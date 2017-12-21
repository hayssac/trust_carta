<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'letter_to', 'letter_from', 'content'
    ]; 

    /**
     * 
     * A letter is written by an user
     */
    public function user() {
        return $this->belongsTo('App\User');
    }   

}
