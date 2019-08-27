<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model {

    protected $table = 'modelo_transaccion';
	protected $primaryKey = 'transaccion_id';
    protected $fillable = [
        'fecha','tipo','valor','descripcion','responsable', 'cuenta_id',
    ];
    
    public $timestamps = false;

    /*
    protected $hidden = [
        'cuenta_id',
    ];*/
    
}
