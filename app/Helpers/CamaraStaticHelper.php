<?php
namespace App\Helpers;

use App\Models\Camara;
use App\Models\DetectorConfig;
use DB;
use Laravie\Parser\Xml\Document;
use Laravie\Parser\Xml\Reader;

class CamaraStaticHelper
{
	public static function getZones($camara_id)
	{
		$detector_config = DetectorConfig::where('detectorId', $camara_id)->first();
		/*

		$xmls = new Reader(new Document());
		$xmls->extract($detector_config->content);
		dd($xmls);
		*/
		$xml = new \SimpleXMLElement($detector_config->content);
		$zones = $xml->TrafficData->TrafficData->Zones->Zone;
		//dd($zones);
		$dict = array();
		foreach ($zones as $zone) {
			//dd($zone);
			$name = $zone->Characteristics->Characteristic['name'];
			dd($zone->Characteristics->Characteristic);
			dd($name);
			if (!array_key_exists($name, $dict)) {
				$dict[$name] = array();
			}
			array_push($dict[$name], $zone['ZoneId']);
		}

		return $dict;
	}

	public static function getPosition($lector_id)
	{
		$data = array(
			'lat' => -16.449965,
			'lng' => -71.587268
		);

		$lector_camara = DB::table('TB_LECTOR_CAMARA')
			->where('id_lector_movimiento', $lector_id)
			->first();

		if ($lector_camara) {

			$cam_ubi = DB::table('TBL_CAMARA_UBICACION')
				->where('cod_camara', $lector_camara->id_camara)
				->first();

			if ($cam_ubi) {

				$ubicacion = DB::table('TB_UBICACION')
					->where('codigo', $cam_ubi->cod_ubicacion)
					->first();

				if ($ubicacion) {
					$data['lat'] = $ubicacion->latitud;
					$data['lng'] = $ubicacion->longitud;
				}
			}
		}
		return '{lat: '.$data['lat'].', lng: '.$data['lng'].'},';
	}
}