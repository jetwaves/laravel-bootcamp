<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Jetwaves\LaravelUtil\CommonUtil;
use JWTAuth;
use App\Models\JwtUserModel as JwtUser;
use JWTAuthException;
use Log;

class JwtUserController extends Controller
{
    private $jwtUser;
    public function __construct(JwtUser $jwtUser){
        $this->jwtUser = $jwtUser;
    }

    public function register(Request $request){
        $userInfo = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ];
        $jwtUser = $this->jwtUser->create($userInfo);
        return ['status'=>true,'message'=>'JwtUser created successfully','data'=>$jwtUser];
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
        return compact('token');
    }


    public function getTest()
    {
        echo 'it works !!!';
    }

    public function postTest()
    {
        echo 'it works (post)!!!';
    }


    /*
     * Jwt User Register API for public service
     *
     * */
    public function postUserRegister(Request $request)
    {
        // 验证规则见    5.1      http://laravelacademy.org/post/240.html#rule-accepted             5.5    http://laravelacademy.org/post/7978.html#toc_17
        $rules = [
            'name'             => 'required|alpha_num|max:50|unique:jwt_user',
            'email'            => 'required|email|max:50|unique:jwt_user',
            'password'         => 'required|alpha_num|max:50',
        ];
        $objData = $request->all();
        $validator = app('validator')->make($objData, $rules);
        if ($validator->fails()) return CommonUtil::getValidatorErrorMessage($validator);

//  Wrapped with function register()
//        $passwordReq = $request->get('password');
//        $userInfo = [
//            'name' => $request->get('name'),
//            'email' => $request->get('email'),
//            'password' => bcrypt($passwordReq)
//        ];
//        Log::info('     '.__method__.'() line:'.__line__.'     $userInfo  = '.print_r($userInfo, true));
//        $jwtUser = $this->jwtUser->create($userInfo);
//        Log::info('     '.__method__.'() line:'.__line__.'     $jwtUser  = '.print_r($jwtUser, true));
//        return response()->json(['status'=>true,'message'=>'JwtUser created successfully','data'=>$jwtUser, 'password' => $userInfo['password'] ]);

        $registerRes = $this->register($request);
        return $registerRes;
    }

    public function postUserLogin(Request $request)
    {
        // 验证规则见    5.1      http://laravelacademy.org/post/240.html#rule-accepted             5.5    http://laravelacademy.org/post/7978.html#toc_17
        $rules = [
            'email'            => 'required|email|max:50',
            'password'         => 'required|max:100',
        ];
        $objData = $request->all();
        $validator = app('validator')->make($objData, $rules);
        if ($validator->fails()) return CommonUtil::getValidatorErrorMessage($validator);

//  Wrapped with function login()
//        $credentials = $request->only('email', 'password');
//        Log::info('     '.__method__.'() line:'.__line__.'     $credentials  = '.print_r($credentials, true));
//        $token = null;
//        try {
//            if (!$token = JWTAuth::attempt($credentials)) {
//                var_dump($token);
//                return response()->json(['invalid_email_or_password'], 422);
//            }
//        } catch (JWTAuthException $e) {
//            return response()->json(['failed_to_create_token'], 500);
//        }
//        return response()->json(compact('token'));

        $loginResult = $this->login($request);
        return $loginResult;

    }

    /*
     * Get user info with token
     * */
    public function getAuthUser(Request $request){
        $jwtUser = JWTAuth::toUser($request->token);
        return response()->json(['result' => $jwtUser]);
    }



}