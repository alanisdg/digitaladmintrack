<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Signes;
use DB;
use DateTime;

class Groups extends Model
{
    protected $fillable = ['user_id','devices','name','type'];

    public function User(){
        return $this->belongsTo(User::class);
    }
    
    
}
