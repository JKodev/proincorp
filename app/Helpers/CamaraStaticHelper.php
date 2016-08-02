<?php
namespace App\Helpers;

use App\Models\Camara;
use App\Models\DetectorConfig;

class CamaraStaticHelper
{
	public static function getZones($camara_id)
	{
		$detector_config = DetectorConfig::where('detectorId', $camara_id)->first();
		$xml = new \SimpleXMLElement($detector_config->content);
		$zones = $xml->TrafficData->TrafficData->Zones;
		dd($zones);
		$dict = array();
		foreach ($zones as $zone) {
			dd($zone);
			$name = $zone->Characteristics->Characteristic['name'];
			if (!array_key_exists($name, $dict)) {
				$dict[$name] = array();
			}
			array_push($dict[$name], $zone['ZoneId']);
		}

		return $dict;
	}
}