<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

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

    public function index(Request $request){
        //return "sin datos";
        $users = User::all();
        return response()->json($users,200);
    }

    public function getUser($id){
        $user = User::find($id);
        if($user){
            return response()->json($user,200);
        }else{
            return response()->json(['error'=>'no encontrado'],401);
        }
    }

    public function all(Request $request){
        if ($request->isJson()){
            $users = User::all();
            return response()->json($users,200);
        }
        return response()->json(['error'=>'no autorizado'],401);
    } 

    public function create(Request $request){
        $usuario = new User();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->username = $request->username;
        $usuario->password = "con clave";
        $usuario->save();
        return response()->json($usuario);
    }
}











