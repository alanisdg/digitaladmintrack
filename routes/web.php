<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
//ROLES
// developer-> 1 cliente-> 2 monitorista-> 3 trafico-> 4 chofer-> 5 master-> 6
use App\User;
use App\Travels;


Route::get('/', function () {
    return view('welcome');
});
//Tracking
Route::get('/tracking', 'TrackingController@index',function(){});
Route::post('get_tracking','TrackingController@get_tracking',function(){});
Auth::routes();

//HOME
Route::get('/home', 'HomeController@index',function(){});

//MAPA
Route::get('/mapa', 'HomeController@mapa',function(){});

//USERS *developer *master
Route::group(['middleware'=>'userRole:1,6,0,0,0,0'],function(){
    Route::get('/users', 'UserController@index',function(){});
    Route::get('/user/edit/{id}', 'UserController@edit',function(){});
    Route::get('/users/add', 'UserController@add',function(){});
    Route::post('/user/editsave', 'UserController@editsave',function(){});
    Route::post('/user/create', 'UserController@create',function(){});
});


 
Route::get('user/{id}', function ($id) {
        $user = User::find($id);
        $devices = $user->getDevices($user);
        return view('users.user',compact('user','devices'));
    });
Route::get('/profile/{id}', 'UserController@profile',function(){});
Route::post('updateprofile', 'UserController@updateprofile',function(){});
Route::post('user/jewel', 'UserController@jewel',function(){});

//REPORTES
Route::get('/reportes', 'ReportsController@index',function(){});
Route::post('reports/get', 'ReportsController@get',function(){});


//TRAVELS
Route::get('/travels', 'TravelsController@index',function(){});
Route::get('/travels/add', 'TravelsController@add',function(){});
Route::post('/travels/create', 'TravelsController@create',function(){});
Route::post('/travel/auth/save', 'TravelsController@authsave',function(){});
Route::post('/travel/auth/edit/save', 'TravelsController@autheditsave',function(){});
Route::post('/travels/create_order', 'TravelsController@create_order',function(){});
Route::post('/travels/delete_order', 'TravelsController@delete_order',function(){});
Route::get('/travel/{id}', 'TravelsController@read',function(){});
Route::get('/travel/edit/{id}', 'TravelsController@edit',function(){});
Route::post('/travel/editsave', 'TravelsController@editsave',function(){});
Route::group(['middleware'=>'userRole:1,6,4,0,0,0'],function(){
    Route::get('/orders', 'TravelsController@orders',function(){});
});



Route::group(['middleware'=>'userRole:1,6,4,0,0,0'],function(){
    Route::get('/clients', 'SubclientsController@index',function(){});
    Route::get('/clients/add', 'SubclientsController@add',function(){});
    Route::get('/client/edit/{id}', 'SubclientsController@edit',function(){});
    Route::post('/client/edit/', 'SubclientsController@editsave',function(){});
});



Route::get('/newtravel', 'TravelsController@newtravel',function(){});

Route::group(['middleware'=>'userRole:1,6,4,0,0,0'],function(){
    Route::get('/travel/auth/{id}', 'TravelsController@auth',function(){});
    Route::get('/travel/auth/edit/{id}', 'TravelsController@authedit',function(){});
    Route::get('/travel/history/{id}', 'TravelsController@history',function(){});
});

Route::post('travel/cancel', 'TravelsController@cancel',function(){});
Route::post('/travel/notification_read', 'TravelsController@notification_read',function(){});


Route::post('travels/get_travels_by', 'TravelsController@get_travels_by',function(){});

//Route::get('travels/get_travels_by/{id}', 'TravelsController@get_travels_by',function(){});

//PACKETS
Route::post('packet/refresh', 'PacketsController@refreshPacket',function(){
});

//DEVICES
Route::get('boxs', 'DevicesController@boxs',function(){});
Route::get('box/{id}', 'DevicesController@device',function(){});
Route::get('trucks', 'DevicesController@trucks',function(){});
Route::get('boxes', 'DevicesController@boxes',function(){});
Route::post('/trucks/get', 'DevicesController@trucksget',function(){});
Route::post('/device/updateDevice', 'DevicesController@updateDevice',function(){});



Route::get('/trucks/get/{id}', 'DevicesController@trucksget',function(){});
Route::get('/device/{id}', 'DevicesController@device',function(){});
Route::post('devices/get_trucks_by_geofence', 'DevicesController@get_trucks_by_geofence',function(){});
// Route::get('devices/get_trucks_by_geofence/{id}', 'DevicesController@get_trucks_by_geofence',function($id){});


//ROUTES
Route::get('/routes', 'RoutesController@index',function(){});
//Route::get('/route/getPosibleRoutes', 'RoutesController@getPosibleRoutes',function(){});

Route::get('/route/{id}', 'RoutesController@read',function(){});
Route::get('/routes/add', 'RoutesController@add',function(){});
Route::post('/route/get', 'RoutesController@get',function(){});
Route::post('/route/getPosibleRoutes', 'RoutesController@getPosibleRoutes',function(){});

Route::post('/route/getdest', 'RoutesController@getdest',function(){});
Route::post('/routes/create', 'RoutesController@create',function(){});
Route::post('/route/edit', 'RoutesController@edit',function(){});

//CLIENTS

Route::get('/client/delete/{id}', 'SubclientsController@delete',function(){});
Route::get('/client/{id}', 'SubclientsController@client',function(){});
Route::get('/toclient/{id}', 'SubclientsController@toclient',function(){});

Route::post('/clients/create', 'SubclientsController@create',function(){});


//DRIVERS
Route::get('/drivers', 'DriversController@index',function(){});
Route::get('/drivers/add', 'DriversController@add',function(){});
Route::get('/driver/{id}', 'DriversController@read',function(){});
Route::post('/drivers/create', 'DriversController@create',function(){});
Route::post('/driver/update', 'DriversController@update',function(){});

//GEOFENCES
Route::get('/geofences', 'GeofencesController@geofences',function(){});
Route::post('/references/get', 'GeofencesController@getReferences',function(){});


//TOOLS
Route::group(['middleware'=>'userRole:1,6,4,3,0,0'],function(){
    Route::get('/tools', 'ToolsController@index',function(){});
});
Route::post('geofences', 'GeofencesController@store', function(){});
Route::post('/geofences/get_all', 'GeofencesController@get_all', function(){});
Route::post('/geofences/get', 'GeofencesController@get', function(){});
Route::get('/geofence/delete/{id}', 'GeofencesController@delete', function(){});


//LOCATIONS
Route::get('/location/{id}', 'LocationsController@read',function(){});
Route::get('/toclientlocation/{id}', 'LocationsController@toclientread',function(){});
Route::get('/location/delete/{id}', 'LocationsController@delete',function(){});
Route::post('/location/save', 'LocationsController@save',function(){});

Route::post('/tolocation/save', 'LocationsController@tolocationsave',function(){});

Route::get('/location/add/{id}', 'LocationsController@add',function(){});
Route::get('/client/add/client/{id}', 'LocationsController@clienttoclient',function(){});
Route::post('locations/get', 'LocationsController@get',function(){});


//    Route::get('locations/get', 'LocationsController@get',function(){});


//PRUEBA DE VIAJES
Route::get('/traveltest', 'TravelsController@traveltest',function(){});
Route::post('/traveltestpost', 'TravelsController@traveltest',function(){});

//PRUEBA DE VIAJES
Route::post('/comments/post', 'CommentsController@post',function(){});

//NOTIFICATIONES
Route::post('notifications/getlastbyauthor','NotificationsController@getlastbyauthor');

use App\Devices;

use Faker\Factory as Faker;

// SMS
Route::post('/nexmo/send', 'NexmoController@send',function(){});
//Route::get('/nexmo/send', 'NexmoController@send',function(){});


//ADMIN ROUTES



Route::group(['middleware'=>'userRole:1,0,0,0,0,0'],function(){

    Route::get('dashboard', 'DashboardController@index',function(){});

    Route::get('/dashboard/read/{id}', function ($id) {
        $device = Devices::find($id);
        return $device;
        //return view('admin.home');
    });

    Route::get('/dashboard/delete/{id}', function ($id) {
        $device = Devices::find($id);
        $device->delete();
        return $device;
        //return view('admin.home');
    });

    //EQUIPOS
    Route::get('dashboard/devices', 'DevicesController@devices',function(){});
    Route::get('dashboard/devices/read/{id}', 'DevicesController@read',function($id){});
    Route::get('dashboard/devices/sms/{id}', 'DevicesController@sms',function($id){});
    Route::get('dashboard/devices/create', 'DevicesController@create',function(){});
    Route::post('dashboard/devices/store', 'DevicesController@store',function(){});
    Route::post('dashboard/devices/update', 'DevicesController@update',function(){});
    Route::post('dashboard/device/delete', 'DevicesController@delete',function(){});


    //PAQUETES
    Route::get('dashboard/packets/{id}', 'PacketsController@packets',function($id){});

    //CLIENTES
    Route::get('dashboard/clients', 'ClientsController@index',function(){});
    Route::get('dashboard/clients/add', 'ClientsController@add',function(){});
    Route::post('dashboard/client/store', 'ClientsController@store',function(){});
    Route::get('dashboard/client/{id}', 'ClientsController@read',function(){});
    Route::post('dashboard/client/update', 'ClientsController@update',function(){});
     



    //USUARIOS
    Route::get('dashboard/users', 'UserController@users',function(){    });
    Route::get('dashboard/user/read/{id}', 'UserController@read',function(){});
    Route::get('dashboard/user/add', 'UserController@addClient',function(){});
    // Route::post('dashboard/user/store', 'UserController@storeClient',function(){});
    Route::post('dashboard/user/store', 'UserController@create_user',function(){});

});
