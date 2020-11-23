<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
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
        $message = new Message;

        $validatedData = $this->validate($request,[
            'message' => 'required',
        ]);

        $message->message = $request->message;

        $message->save();
        return $message;
    }

    public function readOne($id)
    {
        return Message::find($id);
    }

    public function readAll()
    {
        return Message::all();
    }

    // public function update(Request $request, $id)
    // {
        
    // }

    public function destroy()
    {
        $user = Message::find($id);
        $user->delete();
        return("User deleted !");
    }
}
