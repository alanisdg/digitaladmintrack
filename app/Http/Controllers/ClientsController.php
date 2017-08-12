<?php

namespace App\Http\Controllers;

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

}
