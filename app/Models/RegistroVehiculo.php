<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class RegistroVehiculo extends Model
{
	protected $primaryKey = 'ID_Registro';
	protected $table = "TB_REGISTRO_VEHICULOS";
	protected $connection = "sqlsrv";
}