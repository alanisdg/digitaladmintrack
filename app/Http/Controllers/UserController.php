<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use Validator;
use App\User;
use App\Devices;
use App\Clients;
use Auth;
use App\Roles;
use Carbon\Carbon;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }
    public function profile(){
        $user = User::find(Auth::user()->id);
        return view('users.profile', compact( 'user' ));
    }
    public function updateprofile(){
        $file = array('image' => Input::file('image'));
        $user_id= request()->get('user_id');
        $rules = array('image' => 'required');
        $validator = Validator::make($file, $rules);
        $email = request()->get('email');
        $name = request()->get('name');
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            $user = User::find($user_id);
            $user->email = $email;
                $user->name = $name;
                $user->save();
                return Redirect::to('profile/'.$user_id);
            // return Redirect::to('profile/'.$user_id)->withInput()->withErrors($validator);
        }else {
            if (Input::file('image')->isValid()) {
                $file = Input::file('image');
                $path = public_path().'/profile/';
                $image = \Image::make(Input::file('image'));
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName = $user_id.'_'.rand(11111,99999).'.'.$extension; // renameing image
                $image->fit(200);
                $image->save($path.$fileName);
                $image->fit(40);
                $image->save($path.'thumb_'.$fileName);
                $user = User::find($user_id);
                $user->thumb_image = '/profile/thumb_'.$fileName;
                $user->image = '/profile/'.$fileName;
                $user->email = $email;
                $user->name = $name;
                $user->save();
                return Redirect::to('profile/'.$user_id);
            }else{
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('profile/'.$user_id)->withInput()->withErrors($validator);
            }
        }
        /*
        $file = array('image' => Input::file('image'));
        $user_id= request()->get('user_id');
        $rules = array('image' => 'required');
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return Redirect::to('profile/'.$user_id)->withInput()->withErrors($validator);
        }else {
            // checking file is valid.
            if (Input::file('image')->isValid()) {
                $destinationPath = 'profile'; // upload path
                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName = $user_id.'_'.rand(11111,99999).'.'.$extension; // renameing image
                Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
                // sending back with message
                $user = User::find($user_id);
                $user->image = $fileName;
                $user->save();
                return Redirect::to('profile/'.$user_id);
            } else {
                // sending back with error message.
            }
            dd($file);
        }
        */
    }
    public function edit($id){
        $user = User::find($id);
        $client_id = $user->client_id;
        $client = Clients::find($client_id);
        $devices = $client->devices;
        //dd($devices);
        //$devices = $user->getAllDevices($user);
        $devices_by_user = $user->getDevices($user);
        return view('users.edit', compact('user','devices','devices_by_user'));
    }
    public function editinfo(){
        $user = User::find(request()->get('user_id'));
     
        $user->email = request()->get('email');
        $user->name = request()->get('name');

        $user->role_id = request()->get('role_id');
        $user->save();
        return redirect()->to('/dashboard/users');
         
    }
    public function jewel(){
        $user = User::find(Auth::user()->id);
        $user->read=0;
        $user->new_notifications=0;
        $user->save();
        return response()->json('ok');
    }
    public function users(){
        $user = User::find(Auth::user()->id);
        
        $users3 = User::all();
        return view('admin.users.users', compact('users3','user'));
    }
    public function add(){
        $users = User::where('client_id',Auth::user()->id)->get();
        $user = User::find(Auth::user()->id);
        $client_id = $user->client_id;
        $client = Clients::find($client_id);
        $devices = $client->devices;
         
        return view('users.add',compact('devices','user'));
    }
    public function addClient(){
        $user = User::find(Auth::user()->id);
        $roles = Roles::pluck('name','id')->toArray();
        $clients = Clients::pluck('name','id')->toArray();
        $devices = Devices::pluck('name','id')->toArray();
        return view('admin.users.add',compact('devices','roles','clients','devices','user'));
    }
    public function index(){
        $users = User::where('client_id',Auth::user()->client_id)->get();
        $devices = Devices::all();
        return view('users.index', compact('users','devices'));
    }
    public function read($id){
        $user = User::find(Auth::user()->id);
        $user_read = User::find($id);
        $now = Carbon::now('America/Monterrey');
        $roles = Roles::pluck('name','id')->toArray();
        $lastSession = new Carbon($user_read->lastlogin, 'America/Monterrey');
        $timeforhumans = $now->diffForHumans($lastSession);
        $lastSession = $timeforhumans;
        return view('admin.users.read', compact('user','user_read','lastSession','roles'));
    }
    public function storeClient(){
        dd(request()->all());
        $user = User::find(request()->get('id'));
        $user->name = request()->get('name');
        $user->email = request()->get('email');
        $user->role_id = request()->get('role_id');
        $user->save();
        return redirect()->to('/dashboard/users');
    }
    public function create()
    {
        $name = request()->get('name');
        $mail = request()->get('mail');
        $role = request()->get('role');
        $password = request()->get('password');
        $client_id = request()->get('client_id');
        $devices = request()->get('devices');
        
        // SE CREA EL USUARIO
        $user = User::create([
            'name' => $name,
            'email' => $mail,
            'role' => $role,
            'devices' => ' ',
            'password' => bcrypt($password),
            'client_id' => $client_id,
            'role_id' =>$role
        ]);
        $dev = array();
        // SE FORMA EL ARRAY DE USUARIOS
        foreach ($devices as $device) {
            array_push($dev,$device);
        }
        $user->devices_by_user()->sync($dev);
        return redirect()->to('/users');
    }
    public function editsave(){ 
        $devices = request()->get('devices');
        
        $user  = User::find(request()->get('user_id'));
         
        $user->name = request()->get('name');
        $user->email = request()->get('mail');
        $user->role_id = request()->get('role');
        $password = request()->get('password');
        if($password != ''){
            $user->password = bcrypt($password);
        }
        $user->save();
        $dev = array();
        // SE FORMA EL ARRAY DE USUARIOS
        foreach ($devices as $device) {
            array_push($dev,$device);
        }
       
        $user->devices_by_user()->sync($dev);
       
        return redirect()->to('/users');
    }
    public function create_user()
    {
        $name = request()->get('name');
        $mail = request()->get('email');
        $role = request()->get('role_id');
        $password = request()->get('password');
        $client_id = request()->get('client_id');
        // SE CREA EL USUARIO
        $user = User::create([
            'name' => $name,
            'email' => $mail,
            'devices' => ' ',
            'password' => bcrypt($password),
            'client_id' => $client_id,
            'role_id' =>$role
        ]);
        return redirect()->to('/dashboard/users');
    }
}