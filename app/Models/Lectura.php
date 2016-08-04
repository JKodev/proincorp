<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
	protected $primaryKey = 'ID_Lecturas_Fin';
	protected $table = 'TB_LECTURAS_FIN';
	protected $connection = 'sqlsrv';

}