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

	public static function tipo_vehiculo_empresa($lector_id, $length, $start, $draw, $parameters)
	{
		$lector = Lector::find($lector_id);

		$query = DB::connection('sqlsrv')
			->table('LECTURAS_DETALLADAS_LEC_VISIBLE')
			->where('IP', $lector->ip_lector_movimiento);

		if (array_key_exists('date_from', $parameters) && array_key_exists('date_to', $parameters)) {
			if (!empty($parameters['date_from']) && !empty($parameters['date_to'])) {
				$start_date = \DateTime::createFromFormat("d/m/Y", $parameters['date_from']);
				$end_date = \DateTime::createFromFormat("d/m/Y", $parameters['date_to']);
				$query->whereBetween('FECHA', array(
					$start_date->format('d/m/Y 00:00:00'),
					$end_date->format('d/m/Y 00:00:00')
				));
			}
		}

		if (array_key_exists('empresa', $parameters)) {
			if (!empty($parameters['empresa'])) {
				$query->where('RAZON_SOCIAL', 'LIKE', '%'.strtoupper($parameters['empresa']).'%');
			}
		}

		if (array_key_exists('placa', $parameters)) {
			if (!empty($parameters['placa'])) {
				$query->where('PLACA', 'LIKE', '%'.strtoupper($parameters['placa']).'%');
			}
		}

		$data = array(
			'data'  => array(),
			'draw'  =>  $draw,
			'recordsTotal'  =>  $query->count(),
			'recordsFiltered'   =>  $query->count()
		);

		$results = $query->skip($start)->take($length)->get();

		foreach ($results as $result) {
			$data['data'][] = array(
				$result->FECHA,
				$result->PLACA,
				self::buscarVehiculoXPlaca($result->PLACA)->Gru_Vehiculo,
				$result->RAZON_SOCIAL,
				'-'
			);
		}


		return $data;
	}

	public static function autos_dia($lector_id, $fecha)
	{
		$lector = Lector::find($lector_id);
		$hour_start = '00:00:00';
		$hour_end = '00:30:00';

		$results = array();

		while ($hour_end != '00:00:00') {
			$date = \DateTime::createFromFormat('d/m/Y', $fecha)->format('d/m/Y');
			$start_date = $date.' '.$hour_start;
			$end_date = $date.' '.$hour_end;
			$query = DB::connection('sqlsrv')
				->table('SDTR_LECTURAS_VISIBLE')
				->where('ip_lector_movimiento', $lector->ip_lector_movimiento)
				->whereBetween('fecha_hora_lectura', [$start_date, $end_date]);

			$total = $query->count();

			$results[] = array(
				'hour'  =>  $hour_end,
				'total' =>  $total
			);
			$hour_start = $hour_end;
			$timestamp = strtotime($hour_end) + 1800;

			$hour_end = date('H:i:s', $timestamp);

		}

		return $results;
	}
}