<?php

namespace App\Helpers;


use App\Models\Lector;
use App\Models\Lectura;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\DB;

class ReportHelper
{
	public static function buscarVehiculoXPlaca($placa)
	{
		$vehiculo = Vehiculo::find($placa);

		return $vehiculo;
	}

	public static function tipo_vehiculo_porcentual($lector_id, $start_date, $end_date)
	{
		$lector = Lector::find($lector_id);
		$query = DB::connection('sqlsrv')
			->table('TipoVehiculo_Portico')
			->where('dsc_lector_movimiento', $lector->dsc_lector_movimiento)
			->whereBetween('FECHA', [$start_date, $end_date])
			->groupBy('Tip_Vehiculo')
			->selectRaw('Tip_Vehiculo, sum(Expr1) as sum')
			->get();
		return $query;
	}

	public static function tipo_vehiculo_empresa($lector_id, $parameters)
	{
		$lector = Lector::find($lector_id);

		$query = DB::connection('sqlsrv')
			->table('LECTURAS_DETALLADAS_LEC_VISIBLE')
			->where('IP', $lector->ip_lector_movimiento);

		if (in_array('date_from', $parameters) && in_array('date_to', $parameters)) {
			if (!empty($parameters['date_from']) && !empty($parameters['date_to'])) {
				$query->whereBetween('FECHA', array(
					$parameters['date_from'],
					$parameters['date_to']
				));
			}
		}

		if (in_array('empresa', $parameters)) {
			if (!empty($parameters['empresa'])) {
				$query->where('RAZON_SOCIAL', 'LIKE', '%'.strtoupper($parameters['empresa']).'%');
			}
		}

		if (in_array('placa',$parameters)) {
			if (!empty($parameters['placa'])) {
				$query->where('PLACA', 'LIKE', '%'.strtoupper($parameters['placa']).'%');
			}
		}

		$total = $query->count();
		$rests = $query->skip($parameters['start'])->take($parameters['length']);
		$filtered = $rests->count();

		$results = $rests->get();

		$array_data = [];
		foreach ($results as $result) {
			$dt = array(
				$result->FECHA,
				$result->PLACA,
				self::buscarVehiculoXPlaca($result->PLACA)->Gru_Vehiculo,
				$result->RAZON_SOCIAL,
				'-'
			);
			array_push($array_data, $dt);
		}

		$data = array(
			'data'  => $array_data,
			'draw'  =>  4,
			'recordsTotal'  =>  $total,
			'recordsFiltered'   =>  $filtered
		);
		return $data;
	}
}