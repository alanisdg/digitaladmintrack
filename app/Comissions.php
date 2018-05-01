<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comissions extends Model
{
     

    protected $fillable = ['subtotal','motivo','date','user_id'];

 

    public function user(){
        return $this->belongsTo(User::class);
    }
}
