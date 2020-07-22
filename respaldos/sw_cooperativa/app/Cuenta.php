<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model {

    protected $table = 'modelo_cuenta';
	protected $primaryKey = 'cuenta_id';
    protected $fillable = [
        'numero','estado','fechaApertura','saldo','tipoCuenta','cliente_id',
    ];
    
    public $timestamps = false;

    
    
    
}
