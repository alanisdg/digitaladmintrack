<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Notifications;
use App\Devices;
use App\Pops;
use Auth;

class NotificationsController extends Controller
{
    public function openchat(){

        $device_id = request()->get('device_id');
        
                  

        $notifications = Pops::where('devices_id',$device_id)->orderBy('created_at','desc')->take(5)->get();
      

        $notifications = $notifications->reverse();

         $device = Devices::find($device_id);

        $html = "<div class='mtitle'>Unidad ". $device->name .'<span class="glyphicon glyphicon-remove closeconv" aria-hidden="true"></span></div>';
        $html .= "<div class='contmensajes contmensajes".$device->id."'>";
        foreach ($notifications as $notification) {
            $html .= '<div class="notification not  "><span class=" not"  ><div class="not" style="float:left">';

            if($notification->user->thumb_image != null){
                $html.='  <img src="'. $notification->user->thumb_image .'" alt="..." class="img-circle">';
            }else{
                $html .= '<img src="/profile/user.png" alt="..." class="img-circle">';
            }
            $html.= ' </div><div class="not" style="float:left;     padding: 0px 5px; width: 206px;">
                                        <b>'.$notification->user->name.'</b> 
                                        <span class="grey"> '.$notification->timeago($notification->created_at).' </span> 
                                        <br>
                                        <span class="black">'.$notification->comentario.'</span>
                                        </div>
                                    <div class="not" style="clear:both">

                                    </div>
    </span>
                                </div>';
        }
        $html .= "</div>";
        $html .= '<input type="text" class=" textbox coment'.$device->id.'"  name=""><button class="button_coment" profile="'. Auth::user()->thumb_image .'" name="'. Auth::user()->name .'" user_id="'. Auth::user()->id .'" ide="'.$device->id.'" device_name="'.$device->name.'">Enviar';


        
        
        return response()->json($html);
    }
    public function notification_read(){
        $id = request()->get('id');
          //$id = 307;
        $device_id = request()->get('device_id');
       // $device_id = 31;
                 $notification = Notifications::find($id);
        $notification->read=1;
        $notification->save();

        $notifications = Pops::where('devices_id',$device_id)->orderBy('created_at','desc')->take(5)->get();
        //$notifications = array_reverse($notifications);

       // dd($notifications);
        // $notifications = array_reverse($notifications,true);


        $notifications = $notifications->reverse();

         $device = Devices::find($device_id);

        $html = "<div class='mtitle'>Unidad ". $device->name .'<span class="glyphicon glyphicon-remove closeconv" aria-hidden="true"></span></div>';
        $html .= "<div class='contmensajes contmensajes".$device->id."'>";
        foreach ($notifications as $notification) {
            $html .= '<div class="notification not  "><span class=" not"  ><div class="not" style="float:left">';

            if($notification->user->thumb_image != null){
                $html.='  <img src="'. $notification->user->thumb_image .'" alt="..." class="img-circle">';
            }else{
                $html .= '<img src="/profile/user.png" alt="..." class="img-circle">';
            }
            $html.= ' </div><div class="not" style="float:left;     padding: 0px 5px; width: 206px;">
                                        <b>'.$notification->user->name.'</b> 
                                        <span class="grey"> '.$notification->timeago($notification->created_at).' </span> 
                                        <br>
                                        <span class="black">'.$notification->comentario.'</span>
                                        </div>
                                    <div class="not" style="clear:both">

                                    </div>
    </span>
                                </div>';
        } 
        $html .= "</div>";
        $html .= '<input type="text"  " class="textbox coment'.$device->id.'"  name=""><button class="button_coment" profile="'. Auth::user()->thumb_image .'" user_id="'. Auth::user()->id .'" ide="'.$device->id.'" name="'. Auth::user()->name .'" device_name="'.$device->name.'">Enviar';
        
        
        return response()->json($html);
    }

    public function getlastbyauthorMessages(){
        $id = request()->get('author_id');
         $notification = Notifications::where('author_id',$id)->where('user_id',Auth::user()->id)->orderBy('created_at','desc')->first();
        // dd($notification);
        $author = $notification->author->name;

        $n = '<div class="notification not notification'.$notification->id.'" >';
        $n .='<span ide="' . $notification->id .'" device_id="'.$notification->device_id .'"  nid="'.$notification->id.'" user_id="'. Auth::user()->id  .'" class="nlink not" to="'. $notification->link .'">';

        $n .='<div class="not" style="float:left">';
                if($notification->author->thumb_image != null){
                    $n .= '<img src="'. $notification->author->thumb_image .'" alt="..." class="img-circle">';
                }else{
                    $n .='<img src="/profile/user.png" alt="..." class="img-circle">';
                }
        $n .='</div><div class="not" style="float:left;     padding: 0px 5px; width: 240px;">';

            $n .='    <b> '. $notification->author->name .'</b> <span class="black"> '. $notification->nde->description  .  $notification->device->name   .'</span> <br>';
            $n .='    <span class="grey">'. $notification->timeago($notification->created_at) .'</span> </div><div class="not" style="clear:both"></div></span></div>';

        $message =    $notification->author->name .'  '. $notification->nde->description .' '. $notification->device->name;
        return response()->json([
            'notification'=>$n,
            'newnotifications'=>Auth::user()->new_notifications,
            'message'=>$message
            ]);

    

    }
    public function getlastbyauthor(){
        $id = request()->get('id');
        $notification = Notifications::where('author_id',$id)->where('user_id',Auth::user()->id)->orderBy('created_at','desc')->first();
        $author = $notification->author->name;

        $n = '<div class="notification not">';
        $n .='<a ide="' . $notification->id .'" class="nlink not" to="'. $notification->link .'">';

        $n .='<div class="not" style="float:left">';
                if($notification->author->thumb_image != null){
                    $n .= '<img src="'. $notification->author->thumb_image .'" alt="..." class="img-circle">';
                }else{
                    $n .='<img src="/profile/user.png" alt="..." class="img-circle">';
                }
        $n .='</div><div class="not" style="float:left;     padding: 0px 5px; width: 240px;">';

            $n .='    <b> '. $notification->author->name .'</b> <span class="black"> '. $notification->nde->description  .' '. $notification->tcode->code  .'</span> <br>';
            $n .='    <span class="grey">'. $notification->timeago($notification->created_at) .'</span> </div><div class="not" style="clear:both"></div></a></div>';

        $message =    $notification->author->name .'  '. $notification->nde->description  .' '. $notification->tcode->code   ;
        return response()->json([
            'notification'=>$n,
            'newnotifications'=>Auth::user()->new_notifications,
            'message'=>$message
            ]);

    }


}
