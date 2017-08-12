<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Drivers extends Model
{
    protected $fillable = ['name','client_id','image','thumb_image','licence_validity','licence','driver_phone','driver_test_validity','image_test','image_licence','driver_first_day','driver_last_day'];

    public function device(){
        return $this->belongsTo(Devices::class);
    }

    public function licence_status($limit){
        $now = Carbon::now('America/Monterrey');
        $limits =  new Carbon($limit, 'America/Monterrey');
        if ($limits->lt($now)) {
            $response = '<span class="badge badge-red"> Vencida ' . $limit . "</span>";
        }else{
            $response =  $limit;
        }
        return $response;
    }
}
