<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
class ExampleController extends Controller
{
  /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {

            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }

        return response()->json(compact('token'));

        
    }

    public function postRegister(Request $request){
        $this->validate($request,[
            'name' => 'required|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required|min:5',


        ]);
        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = Hash::make($request['password']);
        $user->save();

        return response()->json($user);

    }
    public function getUsersById(Request $request){

        
        $user_id = $request['id'];
        $user = User::find($user_id);
        
        return response()->json($user);

    }

    public function getUsers(){

        $user = User::all();
        
        return response()->json($user);

    }

    public function deleteUsers(Request $request)
    {
        $user_id = $request['id'];
        $user = User::find($user_id);
        $user->delete();

        return response()->json(['message'=>'User Successfully deleted'], 200);
    }
    // public function save()

    // {



    //     DB::table('users')->insert(

    //         ["id" => "1b7161ea8542462dbf21db4ca9e66288",

    //             'name' => 'chioma',

    //             'email' => 'chiomaigbokwe24@gmail.com',

    //             'password' => Hash::make("mnbvcxz1"),

    //         ]

    //     );

    // }



    public function Test()

    {



        $token = $this->jwt->getToken();

        $this->jwt->user();

        $data = $this->jwt->setToken($token)->toUser();

        print_r($data);

      // echo "inside controller";



    }
}
