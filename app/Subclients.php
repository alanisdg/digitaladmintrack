<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subclients extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','description','phone','phone_2','client_id','email'];

    public function index()
    {
        $clients = Subclients::where('subclients.client_id',Auth::user()->client_id)
                ->orderBy('created_at', 'asc')
                ->get();

        return view('clients.index',compact('clients'));
    }



    public function location(){
        // $clients = Locations::where('subclient_id',$id)
            //    ->count();

        return $this->hasMany(Locations::class);
    }

    public function toclient(){
        // $clients = Locations::where('subclient_id',$id)
            //    ->count();

        return $this->hasMany(Toclients::class);
    }

}
