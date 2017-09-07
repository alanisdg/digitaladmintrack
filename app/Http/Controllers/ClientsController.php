<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Clients;
use App\user;
use Auth;
class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }
    public function index(){
        $user = User::find(Auth::user()->id);
        $clients = Clients::all();
        return view('admin.clients.index', compact('clients','user'));
    }

    public function add(){
        $user = User::find(Auth::user()->id);
        return view('admin.clients.add',compact('user') );
    }

    public function store(){
        $user = request()->all();
        Clients::create($user);
        return redirect()->to('dashboard/clients');
    }


    public function update(){
        $file = array('logo' => Input::file('logo'));
         $id = request()->get('client_id');
        $client = Clients::find($id);
        $client->name=request()->get('name');
        if($file['logo'] != null){
            $file = Input::file('logo');
                $path = public_path().'/client_profile/';
                $image = \Image::make(Input::file('logo'));

                $extension = Input::file('logo')->getClientOriginalExtension(); // getting image extension
                $fileName = $id.'_'.rand(11111,99999).'.'.$extension; // renameing image

                 
                $image->save($path.$fileName);
                 
                

                $client->logo = '/client_profile/'.$fileName;


        }

       

        if(request()->get('boxs')==null){
            $client->boxs = 0;
            }else{
            $client->boxs = 1;
            }
        $client->save();
        return redirect()->to('dashboard/client/'.$id); 
    }



    public function read($id){
         $user = User::find(Auth::user()->id);
        $client = Clients::find($id);
       
        return view('admin.clients.read',compact('client','user') );
    }

}
