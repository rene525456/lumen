<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Cliente;
use DB;

class ClienteController extends Controller{
    
    public function __construct(){
        //
    }

    public function all(Request $request){
        $clientes = Cliente::all();
        return response()->json($clientes,200);
    }

    public function allJson(Request $request){
        if($request->isJson()){
            $clientes = Cliente::all();
            return response()->json($clientes,200);
        }
        return response()->json(['error'=>'Unauthorized'],401,[]);
    }

    public function getClienteCedula(Request $request, $cedula){
        if($request->isJson()){
            $cliente = Cliente::where('cedula', $cedula)->get();
            if(!$cliente->isEmpty()){
                return response()->json($cliente,200);
            }else{
                return response()->json(['error'=>'No existe el cliente'],401,[]);
            }
        }
        return response()->json(['error'=>'Unauthorized'],401,[]);
    }

    public function getCuentas(Request $request, $cedula){
        if($request->isJson()){
            $cuentas = DB::select("select * from modelo_cuenta where cliente_id = (select cliente_id from modelo_cliente where cedula = ". $cedula .");");

            return response()->json($cuentas,200);
        }
        return response()->json(['error'=>'Unauthorized'],401,[]);
    }

    public function create(Request $request){
        if($request->isJson()){
            $data = $request->json()->all();
            $cliente = Cliente::create([
                'cedula' => $data['cedula'],
                'nombres' => $data['nombres'],
                'apellidos' => $data['apellidos'],
                'genero' => $data['genero'],
                "estadoCivil" => $data['estadoCivil'],
                "correo" => $data['correo'],
                "telefono" => $data['telefono'],
                "celular" => $data['celular'],
                "direccion" => $data['direccion'],
                //"date_created" => $data['date_created'],
            ]);
            return response()->json($data['cedula'],200);
        }
        return response()->json(['error'=>'Unauthorized'],401,[]);
    }
/*
    public function depositar(Request $request){
        if($request->json()){
            $cuenta = Cuenta::where('numero', $request->numero)->get();
            
        }
    }
*/
}
