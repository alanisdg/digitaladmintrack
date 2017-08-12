<?php
namespace App\Http\Controllers;
use View;
use Auth;

class BaseController extends Controller
{

    public $do;

    public function __construct()
    {
        $user = 5;

        // Fetch the Site Settings object
        $this->do = $user;
    }
}
?>
