<?php

namespace App\Http\Controllers;

use App\Helpers\ReportHelper;
use DB;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Empresa;

class EmpresaController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function index()
    {
    	$empresas = Empresa::all();

    	return view('app.empresa.index', array(
    		'empresas' => $empresas
    	));
    }

    public function vehicles($id)
    {
    	$empresa = Empresa::find($id);

	    $vehicles = DB::table('TB_VEHICULOS')
		    ->join('TB_VEHICULOS_EMPRESA_GRUPO', function (JoinClause $join) {
		    	$join->on('TB_VEHICULOS.ID_Vehiculo', '=', 'TB_VEHICULOS_EMPRESA_GRUPO.ID_Vehiculo');
		    })
		    ->where('TB_VEHICULOS_EMPRESA_GRUPO.ID_Empresa', $id)
		    ->get();

	    return view('app.empresa.vehicles', array(
	    	'empresa'   =>  $empresa,
		    'vehicles'  =>  $vehicles
	    ));
    }

	/**
	 * @param $id integer
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function report($id)
    {
    	$empresa = Empresa::find($id);

	    return view('app.empresa.report', array(
	    	'id'    =>  $id,
	    	'empresa' => $empresa,
		    'title' => $empresa->Nom_Empresa
	    ));
    }

	/**
	 * @param Request $request
	 * @param $id integer
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function serviceReport(Request $request, $id)
    {
	    $length = $request->length;
	    $start = $request->start;
	    $draw = $request->draw;
	    $parameters = $request->filters;
	    $order = $request->order;

	    $data = ReportHelper::empresaReport($id, $length, $start, $draw, $parameters, $order);

	    return response()->json($data);
    }

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function serviceFind(Request $request)
    {
    	$query = strtoupper($request->input('query'));

	    $empresas = Empresa::where('Nom_Empresa', 'LIKE', "%$query%")->get();

	    $data = array();
	    foreach ($empresas as $empresa) {
	    	$data[] = array(
	    		'value'     =>  $empresa->Nom_Empresa,
			    'tokens'    =>  explode(' ', $empresa->Nom_Empresa)
		    );
	    }

	    return response()->json($data);
    }
}
