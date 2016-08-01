<?php
namespace App\Helpers;

use App\Models\Camara;
use App\Models\DetectorConfig;

class CamaraStaticHelper
{
	public static function getZones($camara_id)
	{
		$detector_config = DetectorConfig::where('detectorId', $camara_id)->first();
		dd($detector_config->content);
	}
}