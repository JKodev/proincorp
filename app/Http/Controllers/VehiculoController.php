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
	 * @param $id integer
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function show($id)
    {
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
}
