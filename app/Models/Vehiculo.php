<?php

namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Eloquent
{
	protected $keyType = 'string';
	protected $primaryKey = 'ID_Vehiculo';
	protected $table = 'TB_VEHICULOS';
	protected $connection = 'sqlsrv';
}