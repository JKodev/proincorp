<?php

namespace App\Http\Controllers;

use App\Helpers\ReportHelper;
use App\Helpers\SerializeHelper;
use App\Models\Lector;
use DB;
use Illuminate\Http\Request;
use App\Helpers\CamaraStaticHelper;
use App\Http\Requests;
use App\Models\Camara;

class PorticoController extends Controller
{
	private $colors = ["green-jungle", "blue-sharp", "red-thunderbird", "yellow-gold", "purple-seance", "blue-ebonyclay", "green-turquoise", "grey-salsa", "red-sunglo", "yellow-soft", "purple-medium"];
    public function index()
    {
    	$lectores = Lector::orderBy('dsc_lector_movimiento')->get();
    	return view('app.portico.index', array(
    		'lectores' => $lectores,
    		'colors' => $this->colors
    	));
    }

    public function show($id)
    {
    	$totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
    	$lectores = Lector::orderBy('dsc_lector_movimiento')->get();
    	$lector = Lector::where('id_lector_movimiento', $id)->first();
    	return view('app.portico.show', array(
		    'lector' => $lector,
		    'lectores' => $lectores,
		    'colors' => $this->colors,
		    'totals'    =>  $totals
	    ));

    }

    public function report($id, $report_id)
    {
	    $totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
    	$lector = Lector::find($id);
	    $lectores = Lector::all();
	    $view = '';
	    $variables = array(
	    	'title' => '',
		    'id' => $id,
		    'report_id' => $report_id,
		    'lector' => $lector,
		    'lectores' => $lectores,
		    'colors' => $this->colors,
		    'totals'    =>  $totals
	    );

    	switch ($report_id) {
		    case "1":
				$view = 'app.portico.report.first';
				$variables['title'] = "Autos día";
		    break;
		    case "2":
		    	$variables['title'] = "Tipo de Vehículo";
				$view = 'app.portico.report.second';
		    break;
		    case "3":
		    	$view = 'app.portico.report.third';
				$variables['title'] = "Tipo de Vehículo Empresa";
		    break;
		    case "4":
		    	return view('app.portico.report.fourth');
		    break;
		    default:
		    	break;
	    }

	    return view($view, $variables);
    }

    public function tags($id)
    {
	    $totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
	    $camara = DB::connection('sqlsrv')
		    ->table('TB_LECTOR_CAMARA')
		    ->where('id_lector_movimiento', $id)
		    ->first();
    	$lector = Lector::find($id);
	    $lectores = Lector::all();
    	return view('app.portico.report.tags', array(
    		'title'     =>  'Reporte por Tags',
		    'id'        =>  $id,
    		'lector'    =>  $lector,
		    'lectores'  =>  $lectores,
		    'colors'    =>  $this->colors,
		    'camara'    =>  $camara,
		    'totals'    =>  $totals
	    ));
    }

    public function camaras($id)
    {
	    $totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
    	$camara = DB::connection('sqlsrv')
		    ->table('TB_LECTOR_CAMARA')
		    ->where('id_lector_movimiento', $id)
		    ->first();
	    $lector = Lector::find($id);
	    $lectores = Lector::all();
	    return view('app.portico.report.camaras', array(
		    'title'     =>  'Reporte por Cámaras',
		    'id'        =>  $id,
		    'lector'    =>  $lector,
		    'lectores'  =>  $lectores,
		    'colors'    =>  $this->colors,
		    'camara'    =>  $camara,
		    'totals'    =>  $totals
	    ));
    }

	/**
	 * @param $id integer
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function general($id)
    {
	    $totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
	    $camara = DB::connection('sqlsrv')
		    ->table('TB_LECTOR_CAMARA')
		    ->where('id_lector_movimiento', $id)
		    ->first();
	    $lector = Lector::find($id);
	    $lectores = Lector::all();
	    return view('app.portico.report.general', array(
		    'title'     =>  'Reporte General',
		    'id'        =>  $id,
		    'lector'    =>  $lector,
		    'lectores'  =>  $lectores,
		    'colors'    =>  $this->colors,
		    'camara'    =>  $camara,
		    'totals'    =>  $totals
	    ));
    }

    public function serviceTipoVehiculoPorcentual($id, $start_date, $end_date)
    {
    	$s_date = date("Y-m-d 00:00:00", $start_date);
	    $e_date = date("Y-m-d 23:59:59", $end_date);
		$data = ReportHelper::tipo_vehiculo_porcentual($id, $s_date, $e_date);
	    $serialize = SerializeHelper::fromArray($data, array("Tip_Vehiculo", "sum"));

	    return response()->json($serialize);
    }

    public function serviceTipoVehiculoEmpresa(Request $request, $id)
    {
    	$length = $request->length;
	    $start = $request->start;
	    $draw = $request->draw;
	    $parameters = $request->filters;

    	$data = ReportHelper::tipo_vehiculo_empresa($id, $length, $start, $draw, $parameters);

	    return response()->json($data);
    }

    public function serviceVehiculosDia($id, $date)
    {
    	$f_date = date("d/m/Y", $date);
	    $data = ReportHelper::autos_dia($id, $f_date);

	    return response()->json($data);
    }

    public function serviceTags($id, $date)
    {
    	$f_date = date("d/m/Y", $date);
	    $data = ReportHelper::informe_tags($id, $f_date);

	    $serialize = SerializeHelper::parseToChart($data);

	    return response()->json($serialize);
    }

    public function serviceCamaras($id, $date)
    {
    	$f_date = date("d/m/Y", $date);
	    $data = ReportHelper::informe_camaras($id, $f_date);

	    $serialize = SerializeHelper::parseToChart($data);

	    return response()->json($serialize);
    }

    public function serviceGeneral($id, $date, $direction)
    {
    	$dir = 'Arequipa - CV';
    	if ($direction == 1) {
    		$dir = 'CV - Arequipa';
	    }
	    $f_date = date("d/m/Y", $date);
	    $data = ReportHelper::informe_general($id, $f_date);
		//dd($data);
	    $serialize = SerializeHelper::parseGeneralToChart($data, $dir);

	    return response()->json($serialize);
    }
}
