<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Devices;
use App\Packets;
use App\Configs;
use App\Packets_live;
use App\Clients;
use App\Travels;
use View;
use Auth;
use DB;
use Carbon\Carbon;

class ComposerWrapper extends BaseController
{
     
public function __construct(array $data)
{
    $this->data = $data;
}

public function compose()
{        
    $data = $this->data;

    View::composer('partial_name', function( $view ) use ($data) 
    {
        //here you can use your $data to compose the view
    } );
}
 
}
