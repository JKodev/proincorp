<?php

namespace App\Http\Controllers;

use App\Helpers\ReportHelper;
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

	    $data = ReportHelper::empresaReport($id, $length, $start, $draw, $parameters);

	    return response()->json($data);
    }

    public function serviceFind(Request $request)
    {
    	dd($request->input('query'));
    }
}
