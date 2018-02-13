<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use App\Models\JwtUserModel as JwtUser;
use JWTAuthException;
class JwtUserController extends Controller
{
    private $jwtUser;
    public function __construct(JwtUser $jwtUser){
        $this->jwtUser = $jwtUser;
    }

    public function register(Request $request){
        $jwtUser = $this->jwtUser->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        return response()->json(['status'=>true,'message'=>'JwtUser created successfully','data'=>$jwtUser]);
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['invalid_email_or_password'], 422);
            }
        } catch (JWTAuthException $e) {
            return response()->json(['failed_to_create_token'], 500);
        }
        return response()->json(compact('token'));
    }
    public function getAuthUser(Request $request){
        $jwtUser = JWTAuth::toUser($request->token);
        return response()->json(['result' => $jwtUser]);
    }


    // delete this after test.
    public function getTest()
    {
        echo 'test with success';
    }
}