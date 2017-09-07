<?php
namespace   App\Http\ViewComposers;
use Illuminate\Contracts\View\View;

use Illuminate\Http\Request;
use App\User;
use App\Devices;
use App\Packets;
use App\Travels;
use App\Clients;
use App\Notifications;
use Auth;
use DB;
use Carbon\Carbon;


class HeaderComposer{

    public function __construct()
    {

    }

    public function compose(View $view)
    {
 
        $client = Clients::find(Auth::User()->client_id);
        $total_devices = Devices::where('client_id',Auth::User()->client_id)->where('type_id',1)->get()->count();
        $available_boxes = Devices::where('client_id',Auth::User()->client_id)->where('type_id',2)->get()->count();
        $pending_orders = Travels::where('client_id',Auth::User()->client_id)->where('tstate_id',5)->where('active',1)->get()->count();
        /*
        $available_devices = Devices::where('client_id',Auth::User()->client_id)->where('status',0)->where('type_id',1)->get()->count();
        
        $waiting_devices = Travels::where('client_id',Auth::User()->client_id)->where('tstate_id',1)->get()->count();
        $onroad_devices = Travels::where('client_id',Auth::User()->client_id)->where('tstate_id',2)->get()->count();
        $on_use_boxes = Devices::where('client_id',Auth::User()->client_id)->where('type_id',2)->where('boxs_id','!=',null)->get()->count();
        */

        $total_notifications = Notifications::where('client_id',Auth::User()->client_id)->get()->count();
        $notifications = Notifications::where('client_id',Auth::User()->client_id)->where('user_id',Auth::User()->id)->orderBy('created_at','desc')->take(5)->get();

        $view->with('total_devices',$total_devices);
        $view->with('client_profile',$client);
        //$view->with('onroad_devices',$onroad_devices);
        //$view->with('available_devices',$available_devices);
        //$view->with('waiting_devices',$waiting_devices);
        $view->with('pending_orders',$pending_orders);
        $view->with('available_boxes',$available_boxes);
        //$view->with('on_use_boxes',$on_use_boxes);
        $view->with('total_notifications',$total_notifications);
        $view->with('notifications',$notifications);
    }
}
