<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;


class Empresa extends Eloquent
{
	protected $keyType = 'string';
	protected $primaryKey = 'ID_Empresa';
	protected $connection = "sqlsrv";
	protected $table = "TB_EMPRESAS";
}