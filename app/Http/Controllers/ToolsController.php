<?php

namespace App\Http\Controllers;


use App\Models\Camara;
use App\Models\Lector;
use DB;

class ToolsController extends Controller
{
	public function migrate()
	{
		$camaras = Camara::where('currentConfigurationIndex', -99)->get();

		foreach ($camaras as $camara) {
			DB::connection('sqlsrv')
				->table('TB_CAMARAS')
				->insert(
					[
						'id_camara' =>  $camara->id,
						'nombre'    =>  $camara->cameraName,
						'ip'        =>  $camara->ipaddress
					]
				);
			$name = strtoupper($camara->cameraName);

			$lectores = Lector::where('dsc_lector_movimiento', 'LIKE', '%'.$name.'%');

			if ($lectores->count() > 0) {
				foreach ($lectores as $lector) {
					$head = DB::connection('sqlsrv')
						->table('TB_LECTOR_CAMARA');

					$find = $head
						->where('id_camara', $camara->id)
						->where('id_lector_movimiento', $lector->id_lector_movimiento);

					if ($find->count() == 0) {
						$ruta = 'CV - Arequipa';
						if (strpos($lector->dsc_lector_movimiento, 'AQP-CV') !== false) {
							$ruta = 'Arequipa - CV';
						}
						$head->insert(
							[
								'id_camara' =>  $camara->id,
								'id_lector_movimiento'  =>  $lector->id_lector_movimiento,
								'ruta'  =>  $ruta
							]
						);
					}
				}
			}
		}
	}
}