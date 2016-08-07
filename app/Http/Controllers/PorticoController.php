<?php

namespace App\Http\Controllers;

use App\Helpers\ReportHelper;
use App\Helpers\SerializeHelper;
use App\Models\Lector;
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
    	$lectores = Lector::orderBy('dsc_lector_movimiento')->get();
    	$lector = Lector::where('id_lector_movimiento', $id)->first();
    	return view('app.portico.show', array(
		    'lector' => $lector,
		    'lectores' => $lectores,
		    'colors' => $this->colors
	    ));

    }

    public function report($id, $report_id)
    {
    	$lector = Lector::find($id);
	    $view = '';
	    $variables = array(
	    	'title' => '',
		    'id' => $id,
		    'report_id' => $report_id,
		    'lector' => $lector
	    );

    	switch ($report_id) {
		    case "1":
				$view = 'app.portico.report.first';
				$variables['title'] = "Autos día";
		    break;
		    case "2":
		    	//$variables['results'] = ReportHelper::tipo_vehiculo_porcentual($id, '2016-05-27 00:00:00', '2016-05-27 23:59:59');
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
	    $variables['title'] .= ' - '.preg_replace('/(\d+)\_(\d+)/', " ", $lector->dsc_lector_movimiento);

	    return view($view, $variables);
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
}
