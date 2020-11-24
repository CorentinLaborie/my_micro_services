<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Firebase\JWT\JWT;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(Request $request)
    {
        // BDD //
        $user = new User;
        $validatedData = $this->validate($request,[
            'username' => 'required|unique:users|max:255',
            'password' => 'required',
            'email' => 'required|unique:users|max:255'
        ]);

        $user->username = $request->username; 
        $user->password = $request->password;
        $user->email = $request->email;

        if ($user->save())
        {
            return response()->json(["user" => $user], 200);
        }
    }

    public function readOne(Request $request)
    {
        $key = "COCO";
        $decoded = JWT::decode($request->token, $key, array('HS256'));
        $Select = User::where("username", $decoded->name)->get();
        if(count($Select) > 0){
            $user = User::find($request->id);
            return response()->json(["user" => $user], 200);
        }
    }

    public function readAll()
    {
        return User::all();
    }

    public function update(Request $request)
    {
        $key = "COCO";
        $decoded = JWT::decode($request->token, $key, array('HS256'));
        $Select = User::where("username", $decoded->name)->first();
        if ($Select)
        {
            $validatedData = $this->validate($request,[
                'username' => 'unique:users|max:255',
                'email' => 'unique:users|max:255'
            ]);
            
            if ($request->username != ""){
                $Select->username = $request->username; 
            }
            if ($request->password != ""){
                $Select->password = $request->password;
            }
            if ($request->email != ""){
                $Select->email = $request->email;
            }
            $today = Carbon::now()->toArray();
            $tomorrow = Carbon::now()->addDay()->toArray();
            $payload = array(
                'name' => $Select->password,
                "iat" => $today["timestamp"],
                "exp" => $tomorrow["timestamp"]
            );
            $jwt = JWT::encode($payload, $key);
            $Select->save();
            return response()->json(["token" => $jwt,"user" => $Select], 200);
        }
        else
        {
            return response()->json(["error" => "error"], 400);
        }
    }

    public function destroy(Request $request)
    {
        $key = "COCO";
        $decoded = JWT::decode($request->token, $key, array('HS256'));
        $Select = User::where("username", $decoded->name)->get();
        if(count($Select) > 0){
            $user = User::find($request->id);
            $user->delete();
            return response()->json(["res"=>"User deleted !","user"=>$user], 200);
        }
    }

    public function login(Request $request)
    {
        $validatedData = $this->validate($request,[
            'username' => 'required',
            'password' => 'required',
        ]);

        $Select = User::where("username", $request->username)->get();
        if(count($Select) > 0  && $request->password == $Select[0]->password )
        {
            $today = Carbon::now()->toArray();
            $tomorrow = Carbon::now()->addDay()->toArray();
            $key = "COCO";
            $payload = array(
                "iat" => $today["timestamp"],
                'name' => $Select[0]->username,
                "exp" => $tomorrow["timestamp"]
            );
            $jwt = JWT::encode($payload, $key);
            return response()->json(["token" => $jwt], 200);
        }
        else
        {
            return response()->json(['error' => "UserNotFound"], 400);
        }
    }
}
