<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //

    protected $dates  = ['published_at'];


    public function author(){

    		return $this->belongsTo(Author::class);
    }
}
