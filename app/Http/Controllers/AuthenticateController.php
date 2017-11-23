<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Hash;
class AuthenticateController extends Controller
{
    private $user;
    public function __construct(User $user) {
        $this->user = $user;
    }

    /*
    public function authenticate(Request $request)
    {
        // Get credentials
        $credentials = $request->only('email', 'password');
        // Get user
        $user = $this->user->where('email', $credentials['email'])->first();
        $devices = $user->getAllDevices($user);
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        // all good so return the token
        return response()->json(compact('token','devices'));
    }
    */
    public function authenticate(Request $request)
    {
        // Get credentials
        $credentials = $request->only('email', 'password');
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        // all good so return the token
        return response()->json(['token' => $token],200);
    }
    public function getAuthenticatedUser(Request $request)
{
    
    // $token = JWTAuth::getToken();
    dd($request->bearerToken());
    $user = JWTAuth::parseToken()->toUser();
    dd($user);
        $t = JWTAuth::parseToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsI…xwIn0.ug7aUZRfHgT53zniv_pwZ8xHNB9ySWJ-OHcO0PtMU-8');
        dd($t);
       $user = JWTAuth::toUser('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsI…xwIn0.ug7aUZRfHgT53zniv_pwZ8xHNB9ySWJ-OHcO0PtMU-8');
       
    try {

        if (! $user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }

    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

        return response()->json(['token_expired'], $e->getStatusCode());

    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

        return response()->json(['token_invalid'], $e->getStatusCode());

    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

        return response()->json(['token_absent'], $e->getStatusCode());

    }
    
   
    // the token is valid and we have found the user via the sub claim
    return response()->json(compact('user'));
}

}