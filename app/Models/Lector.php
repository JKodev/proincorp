<?php

namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Lector extends Eloquent
{
	protected $primaryKey = 'id_lector_movimiento';
	protected $table = "SDTR_LECTOR_MOVIMIENTO";
	protected $connection = "sqlsrv";
}