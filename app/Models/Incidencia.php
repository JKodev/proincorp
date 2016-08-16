<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $table = 'TB_INCIDENCIAS';
	protected $connection = 'sqlsrv';
}
