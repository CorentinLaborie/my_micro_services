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

        $user->save();
        return $user;
    }

    public function readOne($id)
    {
        return User::find($id);
    }

    public function readAll()
    {
        return User::all();
    }

    // public function update(Request $request, $id)
    // {
        
    // }

    public function destroy()
    {
        $user = User::find($id);
        $user->delete();
        return("User deleted !");
    }

    public function login(Request $request)
    {
        $validatedData = $this->validate($request,[
            'username' => 'required',
            'password' => 'required',
        ]);

        $Select = User::where("username", $request->username)->get();
        if(count($Select) > 0)
        {
            $today = Carbon::now()->toArray();
            $tomorrow = Carbon::now()->addDay()->toArray();
            $key = "Corentin";
            $payload = array(
                "iat" => $today["timestamp"],
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
