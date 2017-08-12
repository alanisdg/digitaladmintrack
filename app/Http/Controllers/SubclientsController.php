<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subclients;
use App\Toclients;
use Auth;
class SubClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    public function createLocation(){
        dd(request()->all());
    }

    public function client($id)
    {
        $client = Subclients::find($id);

        return view('clients.client',compact('client'));
    }

    public function edit($id)
    {
        $client = Subclients::find($id); 
        return view('clients.edit',compact('client'));
    }

    public function editsave()
    {   
        $client_id = request()->get('client_id');
        $client = Subclients::find($client_id);
        $client->name = request()->get('name');
        $client->direction = request()->get('direction');
        $client->phone = request()->get('phone');
        $client->phone_2 = request()->get('phone_2');
        $client->email = request()->get('email');
        $client->save();
        return redirect()->to('/clients');
    }


    public function toclient($id)
    {
        $client = Subclients::find($id);

        return view('clients.toclient',compact('client'));
    }




    public function index()
    {
        $clients = Subclients::where('subclients.client_id',Auth::user()->client_id)
                ->orderBy('name', 'asc')
                ->get();

        return view('clients.index',compact('clients'));
    }

    public function add()
    {
        return view('clients.add');
    }

    public function delete($id)
    {
        Subclients::where('id',$id)->delete();
        return redirect()->to('/clients');
    }



    public function create()
    {
        $name = request()->get('name');
        $client_id = request()->get('client_id');
        $phone = request()->get('phone');
        $phone_2 = request()->get('phone_2');
        $direction = request()->get('direction');
        $email = request()->get('email');

        Subclients::create([
            'name' => $name,
            'client_id' =>$client_id,
            'phone' =>$phone,
            'phone_2' =>$phone_2,
            'direction' =>$direction,
            'email' =>$email,
        ]);

        return redirect('/clients');


    }

}
