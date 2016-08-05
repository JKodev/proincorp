<?php

namespace App\Helpers;


use App\Models\Lector;
use App\Models\Lectura;
use Illuminate\Support\Facades\DB;

class ReportHelper
{
	public static function tipo_vehiculo_porcentual($lector_id, $start_date, $end_date)
	{
		$lector = Lector::find($lector_id);
		$query = DB::connection('sqlsrv')
			->table('TipoVehiculo_Portico')
			->where('dsc_lector_movimiento', $lector->dsc_lector_movimiento)
			->whereBetween('FECHA', [$start_date, $end_date])
			->groupBy('Tip_Vehiculo')
			->get();
		return $query;
	}
}