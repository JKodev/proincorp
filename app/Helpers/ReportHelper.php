<?php

namespace App\Helpers;


use App\Models\Camara;
use App\Models\Empresa;
use App\Models\Lector;
use App\Models\Lectura;
use App\Models\Vehiculo;
use DB;
use DateTime;
use Debugbar;
use Illuminate\Database\Query\JoinClause;

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
			->groupBy('Gru_Vehiculo')
			->selectRaw('Gru_Vehiculo, sum(Expr1) as sum')
			->get();
		return $query;
	}

	public static function tipoVehiculoPorcentualExcel($lector_id, $start_date, $end_date)
	{
		$lector = Lector::find($lector_id);
		$query = DB::connection('sqlsrv')
			->table('TipoVehiculo_Portico')
			->where('dsc_lector_movimiento', $lector->dsc_lector_movimiento)
			->whereBetween('FECHA', [$start_date, $end_date])
			->get();
		return $query;
	}

	public static function tipoVehiculoEmpresaQuery($lector_id, $start, $length, $parameters, $order)
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
				$query->where('RAZON_SOCIAL', 'LIKE', '%' . strtoupper($parameters['empresa']) . '%');
			}
		}

		if (array_key_exists('placa', $parameters)) {
			if (!empty($parameters['placa'])) {
				$query->where('PLACA', 'LIKE', '%' . strtoupper($parameters['placa']) . '%');
			}
		}

		$total = $query->count();

		switch ($order[0]['column']) {
			case '0':
				$query->orderBy('FECHA', $order[0]['dir']);
				break;
			case '1':
				$query->orderBy('PLACA', $order[0]['dir']);
				break;
			case '3':
				$query->orderBy('RAZON_SOCIAL', $order[0]['dir']);
				break;
			default:
				$query->orderBy('FECHA', $order[0]['dir']);
		}

		if (intval($length) == -1) {
			$results = $query->get();
		} else {
			$results = $query->skip($start)->take($length)->get();
		}

		return array(
			'results' => $results,
			'total' => $total
		);
	}

	public static function tipo_vehiculo_empresa($lector_id, $length, $start, $draw, $parameters, $order)
	{

		$info = self::tipoVehiculoEmpresaQuery($lector_id, $start, $length, $parameters, $order);
		$data = array(
			'data' => array(),
			'draw' => $draw,
			'recordsTotal' => $info['total'],
			'recordsFiltered' => $info['total']
		);

		$results = $info['results'];

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
			$start_date = $date . ' ' . $hour_start;
			$end_date = $date . ' ' . $hour_end;
			$query = DB::connection('sqlsrv')
				->table('TB_LECTURAS_FIN')
				->where('ip_lector_movimiento', $lector->ip_lector_movimiento)
				->whereBetween('fecha_hora_lectura', [$start_date, $end_date]);

			$total = $query->count();

			$results[] = array(
				'Hora' => $hour_end,
				'Vehiculos' => $total
			);
			$hour_start = $hour_end;
			$timestamp = strtotime($hour_end) + 1800;

			$hour_end = date('H:i:s', $timestamp);

		}

		return $results;
	}

	public static function autosDia($lector_id, $fecha)
	{
		$lector = Lector::find($lector_id);
		$date = \DateTime::createFromFormat('d/m/Y', $fecha)->format('d/m/Y');
		$start_date = $date . ' 00:00:00';
		$end_date = $date . ' 23:59:59';
		$query = DB::connection('sqlsrv')
			->table('TB_LECTURAS_FIN')
			->join('TB_REGISTRO_VEHICULOS', function (JoinClause $join) {
				$join->on('TB_REGISTRO_VEHICULOS.cod_tag', '=', 'TB_LECTURAS_FIN.cod_tag');
			})
			->join('TB_VEHICULOS', function (JoinClause $join) {
				$join->on('TB_VEHICULOS.ID_Vehiculo', '=', 'TB_REGISTRO_VEHICULOS.ID_Vehiculo');
			})
			->where('ip_lector_movimiento', $lector->ip_lector_movimiento)
			->whereBetween('fecha_hora_lectura', [$start_date, $end_date])
			->orderBy('fecha_hora_lectura', 'desc')
			->get();

		return $query;
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
		$timer = $date . ' 00:00:00';
		$lenght = intval((60 * 24) / $interval);
		for ($i = 0; $i < $lenght; $i++) {
			$data[$key][$i] = array(
				'hour' => $timer,
				'mount' => 0
			);

			$timestamp = strtotime($timer) + (60 * $interval);
			$timer = date('Y-m-d H:i:s', $timestamp);
		}
	}

	/**
	 * @param $data array
	 * @param $key string
	 * @param $interval integer
	 * @param $start_date DateTime
	 * @param $end_date DateTime
	 */
	private static function generateSimpleIntervalDates(&$data, $key, $interval, $start_date, $end_date)
	{
		$s_date = \DateTime::createFromFormat('Y-m-d H:i:s', $start_date);
		$e_date = DateTime::createFromFormat('Y-m-d H:i:s', $end_date);
		$days = intval($e_date->diff($s_date)->format('%a'));

		if ($days == 0) {
			$days++;
		}

		$length = intval((60 * 24) / $interval) * $days;

		for ($i = 0; $i < $length; $i++) {
			$data[$key][$i] = array(
				'hour' => $s_date->format('Y-m-d H:i:s'),
				'mount' => 0
			);
			$s_date->add(new \DateInterval('PT' . $interval . 'M'));
		}
	}

	/**
	 * @param $data
	 * @param $interval
	 * @param $date
	 */
	private static function generateCompleteInterval(&$data, $interval, $date)
	{
		foreach ($data as $item => $value) {
			self::generateSimpleInterval($data, $item, $interval, $date);
		}
	}

	/**
	 * @param $data array
	 * @param $interval integer
	 * @param $start_date DateTime
	 * @param $end_date DateTime
	 */
	private static function generateCompleteIntervalDates(&$data, $interval, $start_date, $end_date)
	{
		foreach ($data as $item => $value) {
			self::generateSimpleIntervalDates($data, $item, $interval, $start_date, $end_date);
		}
	}

	public static function informe_camaras($detector_id, $date)
	{
		$detector = Camara::find($detector_id);
		$f_date = \DateTime::createFromFormat('d/m/Y', $date)->format('d/m/Y');
		$start_date = $f_date . ' 00:00:00';
		$end_date = $f_date . ' 23:59:59';

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

	/**
	 * @param $detector_id integer
	 * @param $start_date DateTime
	 * @param $end_date DateTime
	 * @return array
	 */
	public static function informe_camaras_fechas($detector_id, $start_date, $end_date)
	{
		$detector = Camara::find($detector_id);

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
		$format_unix_date = \DateTime::createFromFormat('d/m/Y H:i:s', $start_date)->format('Y-m-d');
		$s_date = DateTime::createFromFormat('d/m/Y H:i:s', $start_date)->format('Y-m-d H:i:s');
		$e_date = DateTime::createFromFormat('d/m/Y H:i:s', $end_date)->format('Y-m-d H:i:s');
		self::generateCompleteIntervalDates($data, 10, $s_date, $e_date);

		$valid_format = \DateTime::createFromFormat('d/m/Y H:i:s', $start_date);

		$unix_start_date = $valid_format->getTimestamp();

		foreach ($registers as $register) {
			$register_date = $register->hora;
			$format_date = \DateTime::createFromFormat('Y-m-d H:i:s.u', $register_date);
			$timestamp = $format_date->getTimestamp();

			$position = intval(($timestamp - $unix_start_date) / 600);

			$zone_name = self::getZoneName($zones, $register->id_zona);

			$data[$zone_name][$position]['mount'] += $register->cantidad;
			/*$data[$zone_name][] = array(
				'hour'  =>  $format_date->format('Y-m-d H:i:s'),
				'mount' => $register->cantidad
			);
			*/

		}

		return $data;
	}

	/**
	 * @param $camara_id integer
	 * @param $date DateTime
	 * @return array
	 */
	public static function informe_tags($camara_id, $date)
	{
		$camara = Camara::find($camara_id);

		$lectores = DB::connection('sqlsrv')
			->table('TB_LECTOR_CAMARA')
			->where('id_camara', $camara->id)
			->get();

		$f_date = \DateTime::createFromFormat('d/m/Y', $date)->format('d/m/Y');

		$start_date = $f_date . ' 00:00:00';
		$end_date = $f_date . ' 23:59:59';

		$data = array();

		foreach ($lectores as $lector) {
			$lect = Lector::find($lector->id_lector_movimiento);
			$registers = DB::connection('sqlsrv')
				->table('TB_LECTURAS_FIN')
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

	/**
	 * @param $camara_id integer
	 * @param $start_date DateTime
	 * @param $end_date DateTime
	 * @return array
	 */
	public static function informe_tags_fechas($camara_id, $start_date, $end_date)
	{
		$camara = Camara::find($camara_id);

		$lectores = DB::connection('sqlsrv')
			->table('TB_LECTOR_CAMARA')
			->where('id_camara', $camara->id)
			->get();

		$data = array();

		foreach ($lectores as $lector) {
			$lect = Lector::find($lector->id_lector_movimiento);
			$registers = DB::connection('sqlsrv')
				->table('TB_LECTURAS_FIN')
				->where('ip_lector_movimiento', $lect->ip_lector_movimiento)
				->whereBetween('fecha_hora_lectura', [$start_date, $end_date])
				->get();
			$route_name = $lector->ruta;

			$data[$route_name] = array();
			$formar_unix_date = \DateTime::createFromFormat('d/m/Y H:i:s', $start_date)->format('Y-m-d');

			$s_date = DateTime::createFromFormat('d/m/Y H:i:s', $start_date)->format('Y-m-d H:i:s');
			$e_date = DateTime::createFromFormat('d/m/Y H:i:s', $end_date)->format('Y-m-d H:i:s');
			self::generateSimpleIntervalDates($data, $route_name, 10, $s_date, $e_date);

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

	/**
	 * @param $camara_id integer
	 * @param $date DateTime
	 * @return array
	 */
	public static function informe_general($camara_id, $date)
	{
		$data = array(
			'tags' => self::informe_tags($camara_id, $date),
			'camaras' => self::informe_camaras($camara_id, $date)
		);

		return $data;
	}

	/**
	 * @param $camara_id integer
	 * @param $start_date DateTime
	 * @param $end_date DateTime
	 * @return array
	 */
	public static function informe_general_fechas($camara_id, $start_date, $end_date)
	{
		$data = array(
			'tags' => self::informe_tags_fechas($camara_id, $start_date, $end_date),
			'camaras' => self::informe_camaras_fechas($camara_id, $start_date, $end_date)
		);

		return $data;
	}

	private static function totalAutosDia($lector, $start_date, $end_date)
	{
		$query = DB::connection('sqlsrv')
			->table('TB_LECTURAS_FIN')
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
		$cam = DB::connection('sqlsrv')
			->table('TB_LECTOR_CAMARA')
			->where('id_lector_movimiento', $lector_id)
			->first();
		$camara = Camara::find($cam->id_camara);

		return $camara;
	}

	/**
	 * @param $lector Lector
	 * @param $start_date DateTime
	 * @param $end_date DateTime
	 * @return float|int
	 */
	public static function totalCamaras($lector, $start_date, $end_date)
	{
		$detector = self::getCameraFromLector($lector->id_lector_movimiento);
		$query = DB::connection('sqlsrv')
			->table('TB_DATOS_CAMARA')
			->where('id_indicador', $detector->id)
			->whereBetween('hora', [$start_date, $end_date]);

		$total = $query->sum('cantidad');

		return $total;
	}

	/**
	 * @param $lector Lector
	 * @param $start_date DateTime
	 * @param $end_date DateTime
	 * @return int
	 */
	public static function totalTags($lector, $start_date, $end_date)
	{
		$camara = self::getCameraFromLector($lector->id_lector_movimiento);

		$lectores = DB::connection('sqlsrv')
			->table('TB_LECTOR_CAMARA')
			->where('id_camara', $camara->id)
			->get();

		$total = 0;

		foreach ($lectores as $lector) {
			$lect = Lector::find($lector->id_lector_movimiento);
			$registers = DB::connection('sqlsrv')
				->table('TB_LECTURAS_FIN')
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
			'autos_dia' => self::totalAutosDia($lector, $start_date, $end_date),
			'vehiculos_tipo' => self::totalVehiculosTipo($lector, $start_date, $end_date),
			'vehiculos_empresas' => self::totalVehiculosEmpresas($lector, $start_date, $end_date),
			'camaras' => self::totalCamaras($lector, $start_date, $end_date),
			'tags' => self::totalTags($lector, $start_date, $end_date)
		);

		$data['general'] = $data['camaras'] + $data['tags'];

		return $data;
	}

	/**
	 * @param $empresa_id integer
	 * @param $length integer
	 * @param $start integer
	 * @param $draw integer
	 * @param $parameters array
	 * @return array
	 */
	public static function empresaReport($empresa_id, $length, $start, $draw, $parameters, $order)
	{
		$empresa = Empresa::find($empresa_id);

		$query = DB::connection('sqlsrv')
			->table('LECTURAS_DETALLADAS_LEC_VISIBLE')
			->where('EMPRESA', $empresa_id);

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

		if (array_key_exists('tag', $parameters)) {
			if (!empty($parameters['tag'])) {
				$query->where('TAG', 'LIKE', '%' . strtoupper($parameters['tag']) . '%');
			}
		}

		if (array_key_exists('placa', $parameters)) {
			if (!empty($parameters['placa'])) {
				$query->where('PLACA', 'LIKE', '%' . strtoupper($parameters['placa']) . '%');
			}
		}

		if (array_key_exists('portico', $parameters)) {
			if (!empty($parameters['portico'])) {
				$query->where('PUNTO', 'LIKE', '%' . strtoupper($parameters['portico']) . '%');
			}
		}


		$data = array(
			'data' => array(),
			'draw' => $draw,
			'recordsTotal' => $query->count(),
			'recordsFiltered' => $query->count()
		);

		switch ($order[0]['column']) {
			case '0':
				$query->orderBy('FECHA', $order[0]['dir']);
				break;
			case '1':
				$query->orderBy('TAG', $order[0]['dir']);
				break;
			case '2':
				$query->orderBy('PLACA', $order[0]['dir']);
				break;
			case '3':
				$query->orderBy('PUNTO', $order[0]['dir']);
				break;
			default:
				$query->orderBy('FECHA', $order[0]['dir']);
		}

		if ($length != -1 && $length != '-1') {
			$results = $query->skip($start)->take($length)->get();
		} else {
			$results = $query->get();
		}

		foreach ($results as $result) {
			$data['data'][] = array(
				$result->FECHA,
				$result->TAG,
				$result->PLACA,
				$result->PUNTO,
				'-'
			);
		}


		return $data;
	}

	public static function vehiculoPortico($vehiculo_id, $length, $start, $draw, $parameters)
	{
		$vehiculo = Vehiculo::find($vehiculo_id);

		$query = DB::connection('sqlsrv')
			->table('LECTURAS_DETALLADAS_LEC_VISIBLE')
			->where('PLACA', $vehiculo->ID_Vehiculo);

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

		if (array_key_exists('portico', $parameters)) {
			if (!empty($parameters['portico'])) {
				$query->where('PUNTO', 'LIKE', '%' . strtoupper($parameters['portico']) . '%');
			}
		}

		$data = array(
			'data' => array(),
			'draw' => $draw,
			'recordsTotal' => $query->count(),
			'recordsFiltered' => $query->count()
		);

		$results = $query->skip($start)->take($length)->get();

		foreach ($results as $result) {
			$data['data'][] = array(
				$result->FECHA,
				$result->PUNTO,
				'-'
			);
		}


		return $data;
	}
}