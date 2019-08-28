<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];
    /**
     * define like to user and post relationship.
     * 
     */
    public function likeable()
    {
       return $this->morphTo();
    }
}
