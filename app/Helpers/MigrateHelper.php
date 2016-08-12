<?php

namespace App\Helpers;


use App\Models\DetectorConfig;
use DB;
use XmlParser;

class MigrateHelper
{
	public static function migrate()
	{
		$messages = array();
		$detectorSettings = DetectorConfig::where('configurationIndex', -99);

		if ($detectorSettings->count() > 0) {
			$d_settings = $detectorSettings->get();

			foreach ($d_settings as $d_setting) {
				$xml = XmlParser::extract($d_setting->content);
				$json = json_encode($xml);
				$array = json_decode($json);
				$cantZonas = count($array->TrafficData->TrafficData->Zones->Zone);

				for ($i=0; $i < $cantZonas; $i++) {
					$tmparray = (array)$array->TrafficData->TrafficData->Zones->Zone[$i];
					if (array_key_exists('Characteristics', $tmparray)) {
						$tmparray2 = (array)$tmparray['Characteristics']->Characteristic;

						$stmt = DB::connection('sqlsrv')
							->table('TB_ZONAS_CAMARA')
							->where('id_detector', $d_setting->detectorId)
							->where('id_zona', $tmparray['@attributes']->ZoneId);

						$cc = $stmt->get();

						if ($stmt->count() == 1) {
							$messages[] = "Actualizar $d_setting->detectorId ".$tmparray['@attributes']->ZoneId.' '.$tmparray2['@attributes']->Name;
							DB::connection('sqlsrv')
								->table('TB_ZONAS_CAMARA')
								->where([
									'id_detector'   =>  $d_setting->detectorId,
									'id_zona'       =>  $tmparray['@attributes']->ZoneId
								])
								->update([
									'id_detector'   =>  $d_setting->detectorId,
									'id_zona'       =>  $tmparray['@attributes']->ZoneId,
									'nombre_zona'   =>  $tmparray2['@attributes']->Name
								]);
						} else {
							$messages[] = "Crear $d_setting->detectorId ".$tmparray['@attributes']->ZoneId." ".$tmparray2['@attributes']->Name;
							DB::connection('sqlsrv')
								->table('TB_ZONAS_CAMARA')
								->insert([
									'id_detector'   =>  $d_setting->detectorId,
									'id_zona'       =>  $tmparray['@attributes']->ZoneId,
									'nombre_zona'   =>  $tmparray['@attributes']->Name
								]);
						}
					}
				}
			}
		}
		$q = DB::connection('sqlsrv')
			->table('TB_DATOS_CAMARA')
			->orderBy('hora', 'desc')
			->first();

		$fechaParaActualizar = '2000-01-01 00:00:00';

		if ($q !== null) {
			$fechaParaActualizar = $q->hora;
		}
		$messages[] = "Actualizando desde la fecha: $fechaParaActualizar";

		$query = DB::connection('tmsng_norestore')
			->table('zoneintegrationdataper10m')
			->where('end_date', '>', $fechaParaActualizar);

		if ($query->count() > 0) {
			$messages[] = "Actualizando ".$query->count()." registros.";
			foreach ($query as $q) {
				$num_vehicles1 = ($q->num_vehicles1 !== null)?$q->num_vehicles1:0;
				$num_vehicles2 = ($q->num_vehicles2 !== null)?$q->num_vehicles2:0;
				$num_vehicles3 = ($q->num_vehicles3 !== null)?$q->num_vehicles3:0;
				$num_vehicles4 = ($q->num_vehicles4 !== null)?$q->num_vehicles4:0;
				$num_vehicles5 = ($q->num_vehicles5 !== null)?$q->num_vehicles5:0;

				$cantidad = $num_vehicles1 + $num_vehicles2 + $num_vehicles3 + $num_vehicles4 + $num_vehicles5;
				DB::connection('sqlsrv')
					->table('TB_DATOS_CAMARA')
					->insert([
						'id_indicador'  =>  $q->detector_id,
						'id_zona'       =>  $q->zone_id,
						'hora'          =>  \DateTime::createFromFormat('Y-m-d H:i:s', $q->end_time)->format('d/m/Y H:i:s'),
						'cantidad'      =>  $cantidad

					]);
			}
		} else {
			$messages[] = "No hay datos para actualizar.";
		}

		return $messages;
	}

}
