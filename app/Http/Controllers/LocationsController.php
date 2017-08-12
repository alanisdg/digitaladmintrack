<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Locations;
use App\Toclients;
use App\Geofences;
use App\Subclients;
use Auth;

class LocationsController extends Controller
{
    public function read($id)
    {
        $location = Locations::find($id);
        return view('locations.read',compact('location'));
    }

    public function toclientread($id)
    {
        $location = Toclients::find($id);
        return view('locations.toclientread',compact('location'));
    }

    public function tolocationsave(){
        dd(request()->all());
        $location = Toclients::find(request()->get('location_id'));
        $location->name=request()->get('name');
        $location->direction=request()->get('direction');
        $location->email=request()->get('email');
        $location->phone=request()->get('phone');
        $location->phone_2=request()->get('phone_2');
        $location->save();

        return redirect()->to('/toclientlocation/'.request()->get('location_id'));
    }
    public function save()
    {
        //dd('name');

        $location = Locations::find(request()->get('location_id'));

        $geo_id = $location->geofences_id;
        $geofence = Geofences::find($geo_id);
        $geofence->name = request()->get('name');
        $geofence->save();
        $location->name=request()->get('name');
        $location->direction=request()->get('direction');
        $location->email=request()->get('email');
        $location->phone=request()->get('phone');
        $location->phone_2=request()->get('phone_2');
        $location->save();

        return redirect()->to('/location/'.request()->get('location_id'));
    }

    public function add($id){
        $subclient = Subclients::find($id);
        return view('locations.add',compact('subclient'));
    }

    public function delete($id){
        $location = Locations::where('id',$id)->delete();
        return redirect()->to('/clients');
    }


    public function clienttoclient($id){
        $subclient = Subclients::find($id);
        return view('locations.addclienttoclient',compact('subclient'));
    }

    public function get(){
        //$locations = Locations::find(1);
        $id = request()->get('id');

        $locations = Locations::where('subclients_id',$id)
        ->where('deleted_at',null)
        ->get();
        //$toclients = Toclients::where('subclients_id',$id)->get();

        return response()->json($locations);
        /*
        $locations = Subclients::where('subclients_id',$id);
        return response()->json([
            'locations'=>$locations
        ]); */
    }


}
