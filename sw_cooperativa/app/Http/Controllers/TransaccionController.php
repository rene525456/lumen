<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Cliente;
use App\Cuenta;
use App\Transaccion;
use DB;

class TransaccionController extends Controller{
    
    public function __construct(){
        //
    }

    public function depositar(Request $request){
        if($request->json()){
            $cuenta = Cuenta::where('numero', $request->numero)->get();
            $transaccion = new Transaccion();
            if($cuenta != null){
                $transaccion->fecha = $request->fecha;
                $transaccion->tipo = "depósito";
                $transaccion->valor = $request->valor;
                $transaccion->descripcion = $request->descripcion;
                $transaccion->responsable = $request->responsable;
                $transaccion->date_created = $request->date_created;
                $saldo = $cuenta[0]->saldo + $request->valor;
                $cuenta[0]->saldo = $saldo;
                $cuenta[0]->save();
                $transaccion->cuenta_id = $cuenta[0]->cuenta_id;
                $transaccion->save();

            }
            return response()->json($cuenta[0]->cuenta_id,200);
        }
        return response()->json(['error'=>'Unauthorized'],401,[]);

    }
}
