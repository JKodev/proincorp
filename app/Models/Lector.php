<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Lector extends Model
{
	protected $primaryKey = 'id_lector_movimiento';
	protected $table = "SDTR_LECTOR_MOVIMIENTO";
	protected $connection = "sqlsrv";
}