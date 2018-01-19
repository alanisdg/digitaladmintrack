<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use Validator;
use App\User;
use App\Devices;
use App\Clients;
use App\Invoices;
use Auth;
use App\Roles;
use App\Configs;
use Carbon\Carbon;
use Session;


class InvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }

    public function read($id){
    	$user = User::find(Auth::user()->id);
        $invoices = Invoices::where('client_id',$id)->orderby('year','desc')->orderby('month','desc')->get();


        $client = Clients::find($id);

        return view('admin.invoices.invoices', compact('invoices','user','client'));
    }

        public function get($id){
    	$user = User::find(Auth::user()->id);
        $invoice = Invoices::find($id);
        //dd($invoice);
        $devices = json_decode($invoice->devices,true);
          //dd($devices);
        $client = Clients::find($invoice->client_id);
        return view('admin.invoices.invoice', compact('invoice','user','devices','client'));
    }


}