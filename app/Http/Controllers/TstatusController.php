<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Tstatus;

class TstatusController extends Controller
{
    public function index()
    {
        return view('drivers.index');
    }
}
