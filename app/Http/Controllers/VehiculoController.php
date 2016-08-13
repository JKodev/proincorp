<?php

namespace App\Http\Controllers;

use App\Helpers\ReportHelper;
use App\Models\Empresa;
use App\Models\Vehiculo;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;

class VehiculoController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function index()
    {
    	$vehiculos = Vehiculo::all();

	    return view('app.vehiculos.index', [
	    	'vehiculos' =>  $vehiculos
	    ]);
    }

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function show(Request $request)
    {
    	$id = $request->input('id');
    	$empresa = null;

        $vehiculo = Vehiculo::find($id);
	    $vehiculo_empresa = DB::connection('sqlsrv')
		    ->table('TB_VEHICULOS_EMPRESA_GRUPO')
		    ->where('ID_Vehiculo', $id)->first();

	    if (!is_null($vehiculo_empresa)) {
	    	$empresa = Empresa::find($vehiculo_empresa->ID_Empresa);
	    }

	    $registro = DB::connection('sqlsrv')
		    ->table('TB_REGISTRO_VEHICULOS')
		    ->where('ID_Vehiculo', $id)
		    ->first();

	    return view('app.vehiculos.show', [
	    	'vehiculo'  =>  $vehiculo,
		    'empresa'   =>  $empresa,
		    'registro'  =>  $registro,
		    'id'    =>  $id
	    ]);
    }

	/**
	 * @param Request $request
	 * @param $id integer
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function serviceVehiculoPortico(Request $request, $id)
    {
	    $length = $request->length;
	    $start = $request->start;
	    $draw = $request->draw;
	    $parameters = $request->filters;

	    $data = ReportHelper::vehiculoPortico($id, $length, $start, $draw, $parameters);

	    return response()->json($data);
    }

    public function serviceFind(Request $request)
    {
	    $query = strtoupper($request->input('query'));

	    $vehiculos = Vehiculo::where('ID_Vehiculo', 'LIKE', "%$query%")->get();

	    $data = array();
	    foreach ($vehiculos as $vehiculo) {
		    $data[] = array(
			    'value'     =>  $vehiculo->ID_Vehiculo,
			    'model'     =>  $vehiculo->Mod_Vehiculo,
			    'type'      =>  $vehiculo->Tip_Vehiculo,
			    'brand'     =>  $vehiculo->Mar_Vehiculo,
			    'group'     =>  $vehiculo->Gru_Vehiculo,
			    'tokens'    =>  explode(' ', $vehiculo->ID_Vehiculo)
		    );
	    }

	    return response()->json($data);
    }
}
