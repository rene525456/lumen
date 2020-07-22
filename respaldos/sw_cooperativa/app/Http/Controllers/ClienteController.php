<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Cliente;
use App\Cuenta;
use App\Transaccion;
use DB;
use App\Http\Helper\ResponseBuilder;


class ClienteController extends Controller
{
    public function __construct(){

    }

    public function all(Request $request, $cedula){
            $clientes = Cliente::all();
            return response->json($clientes, 200);
    
    }

    public function getClientePrueba(Request $request, $cedula){
            $cliente = Cliente::where('cedula',$cedula)->get();
            if(!$cliente->isEmpty()){
                $status = true;
                $info  = "Data is listed successfully";
            }else{
                $status = false;
                $info  = "Data is not listed successfully";
            }
            return ResponseBuilder::result($status, $info,$cliente);
    }

    public function getCuentas(Request $request, $cedula){
        if($request->json()){
            $cuenta = DB::select("select * from modelo_cuenta where cliente_id = (select cliente_id from modelo_cliente where cedula = ". $cedula .")");
            if($cuenta != null){
                $status = false;
                $info  = "Data is listed successfully";
            }else{
                $status = false;
                $info  = "Data is not listed successfully";
            }
            return ResponseBuilder::result($status, $info,$cuenta);
        }else{
            $status = false;
            $info  = "Unauthorized";
        }
        return ResponseBuilder::result($status, $info,"sin datos");
    }

    public function getCuenta(Request $request, $numero){
        if($request->json()){
            $cuenta = Cuenta::where('numero',$numero)->get();
            //$cliente = Cliente::where('cedula',$cedula)->get();
            if($cuenta != null){
                $status = true;
                $info  = "Data is listed successfully";
            }else{
                $status = false;
                $info  = "Data is not listed successfully";
            }
            return ResponseBuilder::result($status, $info,$cuenta);
        }else{
            $status = false;
            $info  = "Unauthorized";
        }
        return ResponseBuilder::result($status, $info);
    }

    public function realizarTransaccion(Request $request){
        if($request->json()){
            $cuenta = Cuenta::where('numero',$request->numero)->get();
            $transaccion = new Transaccion();
            //$cliente = Cliente::where('cedula',$cedula)->get();
            if($cuenta != null){
                $transaccion->fecha = $request->fecha;
                $transaccion->tipo = $request->tipo;
                if($request->tipo == 'deposito'){
                    $saldo = $cuenta[0]->saldo + $request->valor;
                    $cuenta[0]->saldo = $saldo;
                    $cuenta[0]->save();
                }
                $transaccion->valor = $request->valor;
                $transaccion->descripcion = $request->descripcion;
                $transaccion->responsable = $request->responsable;
                $transaccion->cuenta_id = $cuenta[0]->cuenta_id;
                $transaccion->save();
                $status = true;
                $info  = "Transaction was done";
            }else{
                $status = false;
                $info  = "Data is not listed successfully";
            }
            return ResponseBuilder::result($status, $info,$transaccion);
        }else{
            $status = false;
            $info  = "Unauthorized";
        }
        return ResponseBuilder::result($status, $info);
    }

}














