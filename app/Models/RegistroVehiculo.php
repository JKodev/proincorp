<?php

namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\Model;

class RegistroVehiculo extends Eloquent
{
	protected $primaryKey = 'ID_Registro';
	protected $table = "TB_REGISTRO_VEHICULOS";
	protected $connection = "sqlsrv";
}