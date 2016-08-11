<?php

namespace App\Helpers;


use App\Models\Camara;
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
				'Hora'  =>  $hour_end,
				'Vehiculos' =>  $total
			);
			$hour_start = $hour_end;
			$timestamp = strtotime($hour_end) + 1800;

			$hour_end = date('H:i:s', $timestamp);

		}

		return $results;
	}

	private static function getZoneName($zones, $zone_id)
	{
		foreach ($zones as $zone) {
			if ($zone->id_zona == $zone_id) {
				return $zone->nombre_zona;
			}
		}
		return '';
	}

	private static function getZonesArray($zones)
	{
		$data = array();
		foreach ($zones as $zone) {
			$name = $zone->nombre_zona;
			if (!array_key_exists($name, $data)) {
				$data[$name] = array();
			}
		}

		return $data;
	}

	/**
	 * @param $data
	 * @param $key
	 * @param $interval
	 * @param $date
	 */
	private static function generateSimpleInterval(&$data, $key, $interval, $date)
	{
		$timer = $date.' 00:00:00';
		$lenght = intval((60*24) / $interval);
		for($i=0; $i < $lenght; $i++) {
			$data[$key][$i] = array(
				'hour'      => $timer,
				'mount'     => 0
			);

			$timestamp = strtotime($timer) + (60 * $interval);
			$timer = date('Y-m-d H:i:s', $timestamp);
		}
	}

	/**
	 * @param $data
	 * @param $interval
	 * @param $date
	 */
	private static function generateCompleteInterval(&$data, $interval, $date)
	{
		foreach ($data as $item=>$value) {
			self::generateSimpleInterval($data, $item, $interval, $date);
		}
	}

	public static function informe_camaras($detector_id, $date)
	{
		$detector = Camara::find($detector_id);
		$f_date = \DateTime::createFromFormat('d/m/Y', $date)->format('d/m/Y');
		$start_date = $f_date.' 00:00:00';
		$end_date = $f_date.' 23:59:59';

		$registers = DB::connection('sqlsrv')
			->table('TB_DATOS_CAMARA')
			->where('id_indicador', $detector->id)
			->whereBetween('hora', [$start_date, $end_date])
			->get();

		$zones = DB::connection('sqlsrv')
			->table('TB_ZONAS_CAMARA')
			->where('id_detector', $detector->id)
			->get();

		$data = self::getZonesArray($zones);
		$format_unix_date = \DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
		self::generateCompleteInterval($data, 10, $format_unix_date);

		$valid_format = \DateTime::createFromFormat('d/m/Y H:i:s', $start_date);

		$unix_start_date = $valid_format->getTimestamp();

		foreach ($registers as $register) {
			$register_date = $register->hora;
			$format_date = \DateTime::createFromFormat('Y-m-d H:i:s.u', $register_date);
			$timestamp = $format_date->getTimestamp();

			$position = intval(($timestamp - $unix_start_date) / 600);

			$zone_name = self::getZoneName($zones, $register->id_zona);

			$data[$zone_name][$position]['mount'] += $register->cantidad;
		}

		return $data;
	}

	public static function informe_tags($camara_id, $date)
	{
		$camara = Camara::find($camara_id);

		$lectores = DB::connection('sqlsrv')
			->table('TB_LECTOR_CAMARA')
			->where('id_camara', $camara->id)
			->get();

		$f_date = \DateTime::createFromFormat('d/m/Y', $date)->format('d/m/Y');

		$start_date = $f_date.' 00:00:00';
		$end_date = $f_date.' 23:59:59';

		$data = array();

		foreach ($lectores as $lector) {
			$lect = Lector::find($lector->id_lector_movimiento);
			$registers = DB::connection('sqlsrv')
				->table('SDTR_LECTURAS_VISIBLE')
				->where('ip_lector_movimiento', $lect->ip_lector_movimiento)
				->whereBetween('fecha_hora_lectura', [$start_date, $end_date])
				->get();
			$route_name = $lector->ruta;

			$data[$route_name] = array();
			$formar_unix_date = \DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d');
			self::generateSimpleInterval($data, $route_name, 10, $formar_unix_date);

			$valid_format = \DateTime::createFromFormat('d/m/Y H:i:s', $start_date);

			$unix_start_date = $valid_format->getTimestamp();

			foreach ($registers as $register) {
				$register_date = $register->fecha_hora_lectura;
				$format_date = \DateTime::createFromFormat('Y-m-d H:i:s.u', $register_date);
				$timestamp = $format_date->getTimestamp();

				$position = intval(($timestamp - $unix_start_date) / 600);

				$data[$route_name][$position]['mount'] += 1;
			}
		}

		return $data;
	}

	public static function informe_general($camara_id, $date)
	{
		$data = array(
			'tags' => self::informe_tags($camara_id, $date),
			'camaras' => self::informe_camaras($camara_id, $date)
		);

		return $data;
	}

	private static function totalAutosDia($lector, $start_date, $end_date)
	{
		$query = DB::connection('sqlsrv')
			->table('SDTR_LECTURAS_VISIBLE')
			->where('ip_lector_movimiento', $lector->ip_lector_movimiento)
			->whereBetween('fecha_hora_lectura', [$start_date, $end_date]);

		$total = $query->count();

		return $total;
	}

	private static function totalVehiculosTipo($lector, $start_date, $end_date)
	{
		$query = DB::connection('sqlsrv')
			->table('TipoVehiculo_Portico')
			->where('dsc_lector_movimiento', $lector->dsc_lector_movimiento)
			->whereBetween('FECHA', [$start_date, $end_date]);
		$total = $query->sum('Expr1');

		return $total;
	}

	private static function totalVehiculosEmpresas($lector, $start_date, $end_date)
	{
		$query = DB::connection('sqlsrv')
			->table('LECTURAS_DETALLADAS_LEC_VISIBLE')
			->where('IP', $lector->ip_lector_movimiento)
			->whereBetween('FECHA', [$start_date, $end_date]);

		$total = $query->count();

		return $total;
	}

	private static function getCameraFromLector($lector_id)
	{
		dd($lector_id);
		$cam = DB::connection('sqlsrv')
			->table('TB_LECTOR_CAMARA')
			->where('id_lector_movimiento', $lector_id)
			->get();
		dd($cam);
		$camara = Camara::find($cam->id_camara);

		return $camara;
	}

	private static function totalCamaras($lector, $start_date, $end_date)
	{
		dd($lector);
		$detector = self::getCameraFromLector($lector->id_lector_movimiento);
		$query = DB::connection('sqlsrv')
			->table('TB_DATOS_CAMARA')
			->where('id_indicador', $detector->id)
			->whereBetween('hora', [$start_date, $end_date]);

		$total = $query->sum('cantidad');

		return $total;
	}

	private static function totalTags($lector, $start_date, $end_date)
	{
		$camara = self::getCameraFromLector($lector);

		$lectores = DB::connection('sqlsrv')
			->table('TB_LECTOR_CAMARA')
			->where('id_camara', $camara->id)
			->get();

		$total = 0;

		foreach ($lectores as $lector) {
			$lect = Lector::find($lector->id_lector_movimiento);
			$registers = DB::connection('sqlsrv')
				->table('SDTR_LECTURAS_VISIBLE')
				->where('ip_lector_movimiento', $lect->ip_lector_movimiento)
				->whereBetween('fecha_hora_lectura', [$start_date, $end_date]);

			$total += $registers->count();
		}

		return $total;
	}

	public static function totalAllReports($lector_id, $start_date, $end_date)
	{
		$lector = Lector::find($lector_id);
		$data = array(
			'autos_dia' =>  self::totalAutosDia($lector, $start_date, $end_date),
			'vehiculos_tipo'    =>  self::totalVehiculosTipo($lector, $start_date, $end_date),
			'vehiculos_empresas'    =>  self::totalVehiculosEmpresas($lector, $start_date, $end_date),
			'camaras'   =>  self::totalCamaras($lector, $start_date, $end_date),
			'tags'      =>  self::totalTags($lector, $start_date, $end_date)
		);

		$data['general'] = $data['camaras'] + $data['tags'];

		return $data;
	}
}