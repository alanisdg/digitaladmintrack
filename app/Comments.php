<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = ['comment','user_id','travel_id','tcode_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
