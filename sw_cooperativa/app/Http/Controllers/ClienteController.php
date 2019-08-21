<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Cliente;
use App\Cuenta;
use DB;
use App\Http\Helper\ResponseBuilder;


class ClienteController extends Controller
{
    public function __construct(){

    }

    public function getCliente(Request $request, $cedula){
        if($request->json()){
            //$cliente = Cliente::find($cedula);
            $cliente = Cliente::where('cedula',$cedula)->get();
            if(!$cliente->isEmpty()){
                $status = true;
                $info  = "Data is listed successfully";
            }else{
                $status = false;
                $info  = "Data is not listed successfully";
            }
            return ResponseBuilder::result($status, $info,$cliente);
        }else{
            $status = false;
            $info  = "Unauthorized";
        }
        return ResponseBuilder::result($status, $info);
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

}














