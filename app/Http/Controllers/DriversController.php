<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Redirect;
use Validator;
use App\Drivers;
use Auth;

class DriversController extends Controller
{
    public function index()
    {
        $drivers = Drivers::where('drivers.client_id',Auth::user()->client_id)
                ->orderBy('licence_validity', 'asc')
                ->get();

        return view('drivers.index',compact('drivers'));
    }

    public function add()
    {
        return view('drivers.add');
    }

    public function read($id)
    {
        $driver = Drivers::find($id);
        return view('drivers.read',compact('driver'));
    }

    public function update()
    {
        $file = array('image' => Input::file('image'));
        $driver_id= request()->get('driver_id');
        $rules = array('image' => 'required');
        $validator = Validator::make($file, $rules);
 
       
        if(Input::file('image_licence') != null){
            if (Input::file('image_licence')->isValid()) {
                $file = Input::file('image_licence');
                $path = public_path().'/driver/';
                $image_licence = \Image::make(Input::file('image_licence'));

                $extension = Input::file('image_licence')->getClientOriginalExtension(); // getting image extension
                $fileName_licence = $driver_id.'_'.rand(11111,99999).'.'.$extension; // renameing image

                $image_licence->fit(200);
                $image_licence->save($path.$fileName_licence);
                $image_licence->fit(40);
                $image_licence->save($path.'thumb_'.$fileName_licence);
            }
        }

        if(Input::file('image_test') != null){
            if (Input::file('image_test')->isValid()) {
                $file = Input::file('image_test');
                $path = public_path().'/driver/';
                $image_test = \Image::make(Input::file('image_test'));

                $extension = Input::file('image_test')->getClientOriginalExtension(); // getting image extension
                $fileName_test = $driver_id.'_'.rand(11111,99999).'.'.$extension; // renameing image

                $image_test->fit(200);
                $image_test->save($path.$fileName_test);
                $image_test->fit(40);
                $image_test->save($path.'thumb_'.$fileName_test);
            }
        }


        $name = request()->get('name');
        $licence = request()->get('licence');
        $licence_validity = request()->get('licence_validity');
        $driver_test_validity = request()->get('driver_test_validity');
        

        $driver_phone = request()->get('driver_phone');
        if($licence_validity == ''){
            $licence_validity = null;
        }

        $driver_first_day = request()->get('driver_first_day');
        $driver_last_day = request()->get('driver_last_day');
      

        if($driver_first_day == ''){
            $driver_first_day =null;
        }

        if($driver_last_day == ''){
            $driver_last_day =null;
        }


        if ($validator->fails()) {
            $driver = Drivers::find($driver_id);

            $driver->name = $name;
            $driver->licence = $licence;
            $driver->licence_validity = $licence_validity;
            $driver->driver_phone = $driver_phone;
            $driver->driver_first_day = $driver_first_day;
            $driver->driver_last_day  = $driver_last_day;
            $driver->driver_test_validity  = $driver_test_validity;
            if(Input::file('image_licence') != null){
                $driver->image_licence = '/driver/'.$fileName_licence;
            }
            if(Input::file('image_test') != null){
                    $driver->image_test = '/driver/'.$fileName_test;
                }
            $driver->save();
            return Redirect::to('drivers');
        }else {
            if (Input::file('image')->isValid()) {
                $file = Input::file('image');
                $path = public_path().'/driver/';
                $image = \Image::make(Input::file('image'));

                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
                $fileName = $driver_id.'_'.rand(11111,99999).'.'.$extension; // renameing image

                $image->fit(200);
                $image->save($path.$fileName);
                $image->fit(40);
                $image->save($path.'thumb_'.$fileName);

                $driver = Drivers::find($driver_id);

                $driver->name = $name;
                $driver->licence = $licence;
                $driver->licence_validity = $licence_validity;
                $driver->driver_first_day = $driver_first_day;
                $driver->driver_last_day  = $driver_last_day;
                $driver->driver_test_validity  = $driver_test_validity;
                $driver->driver_phone = $driver_phone;
                $driver->thumb_image = '/driver/thumb_'.$fileName;
                $driver->image = '/driver/'.$fileName;

                if(Input::file('image_licence') != null){
                    $driver->image_licence = '/driver/'.$fileName_licence;
                }
                if(Input::file('image_test') != null){
                    $driver->image_test = '/driver/'.$fileName_test;
                }
                $driver->save();


                return Redirect::to('drivers');
            }else{
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('driver/'.$driver_id)->withInput()->withErrors($validator);
            }
        }
    }

    public function create()
    {
        $file = array('image' => Input::file('image'));
        $rules = array('image' => 'required');
        $validator = Validator::make($file, $rules);
        $fileName_licence = '';
        $fileName_test = '';


        $name = request()->get('name');
        $licence = request()->get('licence');
        $licence_validity = request()->get('licence_validity');
        $driver_test_validity = request()->get('driver_test_validity');
        
        $driver_first_day = request()->get('driver_first_day');
        $driver_last_day = request()->get('driver_last_day');
        $client_id = request()->get('client_id');
        $driver_phone = request()->get('driver_phone');
        if($licence_validity == ''){
            $licence_validity =null;
        }

        if($driver_first_day == ''){
            $driver_first_day =null;
        }

        if($driver_last_day == ''){
            $driver_last_day =null;
        }

        if ($validator->fails()) {
            $driver = Drivers::create([
                'name' => $name,
                'client_id' =>$client_id,
                'licence' =>$licence,
                'licence_validity' => $licence_validity,
                'driver_phone'=> $driver_phone,
                'driver_last_day'=>$driver_last_day,
                'driver_first_day'=>$driver_first_day,
                'driver_test_validity'=>$driver_test_validity
            ]);

                          if(Input::file('image_licence') != null){
            if (Input::file('image_licence')->isValid()) {
                $file = Input::file('image_licence');
                $path = public_path().'/driver/';
                $image_licence = \Image::make(Input::file('image_licence'));

                $extension = Input::file('image_licence')->getClientOriginalExtension(); // getting image extension
                $fileName_licence = $driver->id.'_'.rand(11111,99999).'.'.$extension; // renameing image

                $image_licence->fit(200);
                $image_licence->save($path.$fileName_licence);
                $image_licence->fit(40);
                $image_licence->save($path.'thumb_'.$fileName_licence);
                $driver->image_licence = '/driver/thumb_'.$fileName_licence;
            }
        }

        if(Input::file('image_test') != null){
            if (Input::file('image_test')->isValid()) {
                $file = Input::file('image_test');
                $path = public_path().'/driver/';
                $image_test = \Image::make(Input::file('image_test'));

                $extension = Input::file('image_test')->getClientOriginalExtension(); // getting image extension
                $fileName_test = $driver->id.'_'.rand(11111,99999).'.'.$extension; // renameing image

                $image_test->fit(200);
                $image_test->save($path.$fileName_test);
                $image_test->fit(40);
                $image_test->save($path.'thumb_'.$fileName_test);
                $driver->image_test = '/driver/thumb_'.$fileName_test;
            }
        }
        
                $driver->save();

            return redirect('/drivers');
        }else {
            if (Input::file('image')->isValid()) {
                $file = Input::file('image');
                $path = public_path().'/driver/';
                $image = \Image::make(Input::file('image'));

                $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension

                $driver = Drivers::create([
                    'name' => $name,
                    'client_id' =>$client_id,
                    'licence' =>$licence,
                    'licence_validity' => $licence_validity,
                    'driver_phone'=> $driver_phone,
                    'driver_last_day'=>$driver_last_day,
                    'driver_first_day'=>$driver_first_day,
                    'driver_test_validity'=>$driver_test_validity

                ]);
                $fileName = $driver->id.'_'.rand(11111,99999).'.'.$extension; // renameing image

                $image->fit(200);
                $image->save($path.$fileName);
                $image->fit(40);
                $image->save($path.'thumb_'.$fileName);

                $driver->image = '/driver/'.$fileName;
                $driver->thumb_image = '/driver/thumb_'.$fileName;

                if(Input::file('image_licence') != null){
            if (Input::file('image_licence')->isValid()) {
                $file = Input::file('image_licence');
                $path = public_path().'/driver/';
                $image_licence = \Image::make(Input::file('image_licence'));

                $extension = Input::file('image_licence')->getClientOriginalExtension(); // getting image extension
                $fileName_licence = $driver->id.'_'.rand(11111,99999).'.'.$extension; // renameing image

                $image_licence->fit(200);
                $image_licence->save($path.$fileName_licence);
                $image_licence->fit(40);
                $image_licence->save($path.'thumb_'.$fileName_licence);
                $driver->image_licence = '/driver/thumb_'.$fileName_licence;
            }
        }

        if(Input::file('image_test') != null){
            if (Input::file('image_test')->isValid()) {
                $file = Input::file('image_test');
                $path = public_path().'/driver/';
                $image_test = \Image::make(Input::file('image_test'));

                $extension = Input::file('image_test')->getClientOriginalExtension(); // getting image extension
                $fileName_test = $driver->id.'_'.rand(11111,99999).'.'.$extension; // renameing image

                $image_test->fit(200);
                $image_test->save($path.$fileName_test);
                $image_test->fit(40);
                $image_test->save($path.'thumb_'.$fileName_test);
                $driver->image_test = '/driver/thumb_'.$fileName_test;
            }
        }


                $driver->save();


                return redirect('/drivers');
            }else{
                Session::flash('error', 'uploaded file is not valid');
                return Redirect::to('driver/add')->withInput()->withErrors($validator);
            }
        }
        $name = request()->get('name');
        $client_id = request()->get('client_id');
    }
}
