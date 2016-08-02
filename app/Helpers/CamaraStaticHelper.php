<?php
namespace App\Helpers;

use App\Models\Camara;
use App\Models\DetectorConfig;
use Laravie\Parser\Xml\Document;
use Laravie\Parser\Xml\Reader;

class CamaraStaticHelper
{
	public static function getZones($camara_id)
	{
		$detector_config = DetectorConfig::where('detectorId', $camara_id)->first();
		$xmls = new Reader(new Document());
		$xmls->extract($detector_config->content);
		dd($xmls);
		dd($detector_config->toArray());
		$xml = new \SimpleXMLElement($detector_config->content);
		$zones = $xml->TrafficData->TrafficData->Zones->Zone;
		//dd($zones);
		$dict = array();
		foreach ($zones as $zone) {
			//dd($zone);
			$name = $zone->Characteristics->Characteristic['name'];
			dd($name);
			if (!array_key_exists($name, $dict)) {
				$dict[$name] = array();
			}
			array_push($dict[$name], $zone['ZoneId']);
		}

		return $dict;
	}
}