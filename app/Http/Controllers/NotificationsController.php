<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Notifications;
use Auth;

class NotificationsController extends Controller
{
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
