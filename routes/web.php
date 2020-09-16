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
    return view('welcome2');
});
Route::get('/landing3', function () {
    return view('landing3');
});
Route::get('/aviso', function () {
    return view('aviso');
});

Route::post('/send/contact', 'CronsController@sendMail',function(){});
Route::post('/send/contact/landing', 'CronsController@sendLanding',function(){});

Route::get('/clean_cron', 'CronsController@clean',function(){});
  Route::get('/cv', 'CronsController@cv',function(){});
Route::get('/sendAlerts', 'CronsController@sendAlerts',function(){});
Route::get('/updatehistory', 'CronsController@updatehistory',function(){});
Route::get('/soriana', 'CronsController@soriana',function(){});
Route::get('/soriana_uda', 'CronsController@soriana_uda',function(){});
Route::get('reports/long', 'CronsController@long',function(){});
Route::get('count', 'CronsController@count',function(){});
Route::get('/whirpool', 'CronsController@whirpool',function(){});
Route::get('/mondelez', 'CronsController@mondelez',function(){});
Route::get('/kronh', 'CronsController@kronh',function(){});
Route::get('/iron', 'CronsController@iron',function(){});
Route::get('/dayReport', 'CronsController@dayReport',function(){});





    

Route::post('logingap',function(){
//return view('welcome');
return response()->json('{"res":ok}');

});

//Tracking
Route::get('/tracking', 'TrackingController@index',function(){});
Route::post('get_tracking','TrackingController@get_tracking',function(){});
Auth::routes();

Route::group(['middleware'=>'CheckAccess'],function(){
//HOME
Route::get('/home2', 'HomeController@home2',function(){});
Route::get('/home', 'HomeController@index',function(){});
Route::get('/hometest', 'HomeController@hometest',function(){});
Route::get('/debug', 'HomeController@debug',function(){});
Route::get('/demo', 'HomeController@demo',function(){});

//MAPA
Route::get('/mapa', 'HomeController@mapa',function(){});

//USERS *developer *master
Route::group(['middleware'=>'userRole:1,6,3,0,0,0,0'],function(){
    Route::get('/users', 'UserController@index',function(){});
    Route::get('/user/edit/{id}', 'UserController@edit',function(){});
    Route::get('/user/edittodo/{id}', 'UserController@edit',function(){});
    Route::get('/users/add', 'UserController@add',function(){});
    Route::post('/user/editsave', 'UserController@editsave',function(){});
    Route::post('/user/create', 'UserController@create',function(){});
    Route::get('/user/delete_this/{$id}', 'UserController@delete',function(){});

});

Route::group(['middleware'=>'userRole:1,6,0,0,0,0,0'],function(){

    Route::get('/user/delete/{id}', 'UserController@delete',function(){});
    Route::get('/delete/total/{id}', 'UserController@deletetotal',function(){});

});

// ESTADOS


//GUARDIA
Route::group(['middleware'=>'userRole:1,6,7,0,0,0,0'],function(){
    Route::post('/wheel/insert', 'DevicesController@wheelinsert',function(){});
    Route::post('device/timeIngeo', 'DevicesController@geopost',function(){});
    
    
    Route::get('/allalerts', 'DevicesController@allalerts',function(){});
    Route::post('/insert/coment', 'DevicesController@insertcoment',function(){});
    Route::post('/getpop', 'DevicesController@getpop',function(){});
    Route::post('/wheel/confirm', 'DevicesController@wheelconfirm',function(){});
    Route::post('/wheel/confirm/out', 'DevicesController@wheelconfirmout',function(){});
    Route::post('/wheel/changeStore', 'DevicesController@changeStore',function(){});
    Route::post('/confirm/change/wheel', 'DevicesController@wheelconfirmchange',function(){});


    Route::get('/wheel/change/{device_id}/{wheel}/{wheelid}/{alertid}', 'DevicesController@changeWheelConfirm',function(){});
    Route::get('/wheel/ignore/{wheel}/{alertid}/{device_id}', 'DevicesController@changeWheelIgnore',function(){});
    Route::get('/changeWheelTrucktoTruck', 'DevicesController@changeWheelTrucktoTruck',function(){});
    Route::get('/guardia', 'HomeController@guardia',function(){});
    Route::get('/guardia_list', 'DevicesController@guardiaList',function(){});
    Route::get('/longreport', 'DevicesController@longReport',function(){});
    Route::get('/guardia_list_in', 'DevicesController@guardiaListIn',function(){});
    Route::get('/changeWheel', 'DevicesController@changeWheel',function(){});
    Route::get('/device/addinfo/{id}', 'DevicesController@addinfo',function(){});
    Route::get('/device/addinfoout/{id}', 'DevicesController@addinfoout',function(){});
    Route::get('/tocheck/{id}', 'DevicesController@tocheck',function(){});
    Route::get('/device/change/{id}', 'DevicesController@change',function(){});
    Route::get('/changes/{id}/{alert}', 'DevicesController@changes',function(){});

    Route::post('/get/wheels', 'DevicesController@getWheels',function(){});
    Route::post('/wheel/changeTrucktoTruck', 'DevicesController@changeTrucktoTruck',function(){});
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
Route::get('reportes/full', 'ReportsController@get',function(){});
Route::post('report/get', 'ReportsController@getLong',function(){});
Route::get('report', 'ReportsController@longReport',function(){});


//REPORTES
Route::get('/cajas', 'DevicesController@cajas',function(){});
Route::get('/cajas2', 'DevicesController@cajas2',function(){});
Route::get('/cajas/excel', 'DevicesController@downloadExcelCajas',function(){});
Route::get('/reports/{imei}/{dateini}/{dateend}', 'DevicesController@downloadExcelReportes',function(){});

Route::get('/chat', 'DevicesController@chat',function(){});


//GROUPS
Route::post('/insert/group', 'GroupsController@insert',function(){});
Route::post('/addto/group', 'GroupsController@addto',function(){});
Route::post('/removeto/group', 'GroupsController@removeto',function(){});
Route::post('/get/groups', 'GroupsController@getgroups',function(){});
Route::post('/delete/group', 'GroupsController@delete',function(){});

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
Route::group(['middleware'=>'userRole:1,6,4,0,0,0,0'],function(){
    Route::get('/orders', 'TravelsController@orders',function(){});
});



Route::group(['middleware'=>'userRole:1,6,4,0,0,0,0'],function(){
    Route::get('/clients', 'SubclientsController@index',function(){});
    Route::get('/clients/add', 'SubclientsController@add',function(){});
    Route::get('/client/edit/{id}', 'SubclientsController@edit',function(){});
    Route::post('/client/edit/', 'SubclientsController@editsave',function(){});
});



Route::get('/newtravel', 'TravelsController@newtravel',function(){});

Route::group(['middleware'=>'userRole:1,6,4,0,0,0,0'],function(){
    Route::get('/travel/auth/{id}', 'TravelsController@auth',function(){});
    Route::get('/travel/auth/edit/{id}', 'TravelsController@authedit',function(){});
    Route::get('/travel/history/{id}', 'TravelsController@history',function(){});
});

Route::post('travel/cancel', 'TravelsController@cancel',function(){});
Route::post('/travel/notification_read', 'TravelsController@notification_read',function(){});
Route::post('/openchat', 'NotificationsController@openchat',function(){});


Route::post('travels/get_travels_by', 'TravelsController@get_travels_by',function(){});

//Route::get('travels/get_travels_by/{id}', 'TravelsController@get_travels_by',function(){});

//PACKETS
Route::post('packet/refresh', 'PacketsController@refreshPacket',function(){
});

//DEVICES
Route::post('device/ubicacion', 'DevicesController@ubicacion',function(){});
Route::post('device/get_history', 'DevicesController@getHistory',function(){});
Route::get('boxs', 'DevicesController@boxs',function(){});
Route::get('box/{id}', 'DevicesController@device',function(){});
Route::get('edit/history/{id}', 'DevicesController@editHistory',function(){});
Route::get('trucks', 'DevicesController@trucks',function(){});
Route::get('boxes', 'DevicesController@boxes',function(){});
Route::post('device/getidSigne', 'DevicesController@getidSigne',function(){});

Route::post('/trucks/get', 'DevicesController@trucksget',function(){});
Route::post('device/updateStatus', 'DevicesController@updateStatus',function(){});
Route::post('device/editStatus', 'DevicesController@editStatus',function(){});
Route::post('/device/updateDevice', 'DevicesController@updateDevice',function(){});
Route::post('device/updateBlock', 'DevicesController@updateBlock',function(){});
Route::post('device/getPanic', 'DevicesController@getPanic',function(){});
Route::post('device/getEnganche', 'DevicesController@getEnganche',function(){});
Route::post('device/finishPanic', 'DevicesController@finishPanic',function(){});
Route::post('device/checkDelay', 'DevicesController@checkDelay',function(){});
Route::post('stop/jammer', 'DevicesController@stopJammer',function(){});
Route::get('/wheel/history/{id}/{wheel}', 'DevicesController@historyWheel',function(){});



Route::get('/trucks/get/{id}', 'DevicesController@trucksget',function(){});
Route::group(['middleware'=>'userRole:1,6,4,3,0,0,0'],function(){
    Route::get('/device/{id}', 'DevicesController@device',function(){});
});

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
Route::post('/search/geofence', 'GeofencesController@search',function(){});
Route::post('/get/states', 'GeofencesController@states',function(){});
//TOOLS
Route::group(['middleware'=>'userRole:1,6,4,3,0,0,0'],function(){
    Route::get('/tools', 'ToolsController@index',function(){});
});
Route::post('geofences', 'GeofencesController@store', function(){});
Route::post('/geofences/get_all', 'GeofencesController@get_all', function(){});
Route::post('/geofences/get', 'GeofencesController@get', function(){});
Route::post('/geofences/get/history', 'GeofencesController@get_history', function(){});
Route::post('/geofence/update', 'GeofencesController@update', function(){});
Route::get('/geofence/delete/{id}', 'GeofencesController@delete', function(){});
Route::get('/geofence/edit/{id}', 'GeofencesController@edit', function(){});


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
Route::post('notifications/getlastbyauthorMessages','NotificationsController@getlastbyauthorMessages');

Route::post('/message/notification_read', 'NotificationsController@notification_read',function(){});

 });
use App\Devices;

use Faker\Factory as Faker;

// SMS
Route::get('/nexmo/send', 'NexmoController@send',function(){});


//ADMIN ROUTES



Route::group(['middleware'=>'userRole:1,0,0,0,0,0,0'],function(){

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
    Route::post('dashboard/devices/devices_by_client', 'DevicesController@getDevicesByClient',function(){});
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

    //GASTOS
    
    Route::get('/dashboard/gastos', 'AdminController@index',function(){});
    Route::get('/dashboard/gastos/add', 'AdminController@add',function(){});
    Route::post('/dashboard/gastos/store', 'AdminController@store',function(){});

    Route::get('dashboard/ingresos', 'AdminController@ingresos',function(){});
    Route::get('/dashboard/ingresos/add', 'AdminController@addingreso',function(){});
    Route::post('dashboard/ingresos/store', 'AdminController@storeingreso',function(){});

    Route::get('dashboard/comisiones', 'AdminController@comisiones',function(){});
    Route::get('/dashboard/comisiones/add', 'AdminController@addcomision',function(){});
    Route::post('dashboard/ingresos/store', 'AdminController@storecomision',function(){});

    Route::get('dashboard/balance', 'AdminController@balance',function(){});
    
    Route::get('dashboard/recuperacion', 'AdminController@recuperacion',function(){});
    


    


    //USUARIOS
    Route::get('dashboard/users', 'UserController@users',function(){    });
    Route::get('dashboard/user/read/{id}', 'UserController@read',function(){});
    Route::get('dashboard/user/add', 'UserController@addClient',function(){});
    Route::get('dashboard/user/guest/{id}', 'UserController@guest',function(){});
    // Route::post('dashboard/user/store', 'UserController@storeClient',function(){});
    Route::post('dashboard/user/store', 'UserController@create_user',function(){});
    Route::post('dashboard/user/edit', 'UserController@editinfo',function(){});

});
