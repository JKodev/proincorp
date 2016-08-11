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
			$base = DB::connection('sqlsrv')
				->table('TB_CAMARAS');

			$search = $base->where([
				['id_camara', '=', $camara->id],
				['nombre', '=', $camara->cameraName],
				['ip', '=', $camara->ipaddress]
			]);

			if ($search->count() == 0) {
				$base->insert(
					[
						'id_camara' =>  $camara->id,
						'nombre'    =>  $camara->cameraName,
						'ip'        =>  $camara->ipaddress
					]
				);
			}

			$separate = explode("_", $camara->cameraName);
			$name = strtoupper($separate[1]);

			echo "Se ha creado la camara: <strong>".$camara->cameraName."</strong><br>";

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
						echo "Se ha registrado el lector: <strong>$lector->dsc_lector_movimiento</strong> en la ruta <strong>$ruta</strong><br>";
					}
				}
			} else {
				echo "No se ha encontrado lectores coincidentes con la cámara: <strong>".$camara->cameraName."</strong><br>";
			}
		}
	}
}