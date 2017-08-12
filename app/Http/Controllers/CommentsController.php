<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use App\Comments;
use Auth;
class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $user_auth = $this->user =  \Auth::User();
    }
    public function post(){

        $comment = Comments::create([
            'user_id' => request()->get('user_id'),
            'comment' =>request()->get('comment'),
            'travel_id' => request()->get('travel_id'),
            'tcode_id' => request()->get('tcode_id')
        ]);
        $user = User::find(request()->get('user_id'));
        return response()->json([
            'comment' =>$comment,
            'user'=>$user
        ]);
    }



}
