<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gastos extends Model
{
     

    protected $fillable = ['subtotal','concepto','date','user_id','user_id_p'];

 

    public function user(){
        return $this->belongsTo(User::class);
    }
}
