<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingresos extends Model
{
     

    protected $fillable = ['subtotal','concepto','date','user_id','client_id'];

 

    public function user(){
        return $this->belongsTo(User::class);
    }
}
