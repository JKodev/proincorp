<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Empresa extends Model
{
	protected $connection = "sqlsrv";
	protected $table = "TB_EMPRESAS";
}