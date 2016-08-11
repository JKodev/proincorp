<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
	protected $keyType = 'string';
	protected $primaryKey = 'ID_Vehiculo';
	protected $table = 'TB_VEHICULOS';
	protected $connection = 'sqlsrv';
}