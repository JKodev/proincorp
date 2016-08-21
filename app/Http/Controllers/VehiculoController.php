<?php

namespace App\Http\Controllers;

use App\Helpers\ReportHelper;
use App\Models\Empresa;
use App\Models\Vehiculo;
use DateTime;
use DB;
use Illuminate\Database\Query\JoinClause;
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

    public function serviceFlow(Request $request)
    {
    	$date = DateTime::createFromFormat('Y-m-d H:i:s', $request->input('date', date('Y-m-d H:i:s')))
		    ->format('d/m/Y H:i:s');

	    $registers = DB::table('LECTURAS_DETALLADAS_LEC_VISIBLE')
		    ->where('FECHA', '<=', $date)
		    ->orderBy('FECHA', 'desc')
		    ->skip(0)
		    ->take(20)
		    ->get();

	    $data = array();
	    foreach ($registers as $register) {
	    	$data[] = array(
	    		'image'     =>  ReportHelper::getVehicleImage($register->PLACA),
			    'empresa'   =>  $register->RAZON_SOCIAL,
			    'placa'     =>  $register->PLACA,
			    'date'      =>  date('d/m/Y H:i:s', strtotime($register->FECHA)),
			    'lector'    =>  preg_replace('/(\d+)\_(\d+)/', " ", $register->PUNTO)
		    );
	    }

	    $response = array(
	    	'success'   =>  true,
		    'results'   =>  $data
	    );
	    return response()->json($response);
    }
}
