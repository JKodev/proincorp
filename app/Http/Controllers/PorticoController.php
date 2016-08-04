<?php

namespace App\Http\Controllers;

use App\Models\Lector;
use Illuminate\Http\Request;
use App\Helpers\CamaraStaticHelper;
use App\Http\Requests;
use App\Models\Camara;

class PorticoController extends Controller
{
    public function index()
    {
    	$colors = ["green-jungle", "blue-sharp", "red-thunderbird", "yellow-gold", "purple-seance", "blue-ebonyclay", "green-turquoise", "grey-salsa", "red-sunglo", "yellow-soft", "purple-medium"];
    	//$camaras = Camara::where('currentConfigurationIndex', '-99')->orderBy('cameraName', 'ASC')->get();
	    $lectores = Lector::orderBy('dsc_lector_movimiento')->get();
    	return view('app.portico.index', array(
    		'lectores' => $lectores,
    		'colors' => $colors
    	));
    }

    public function show($id)
    {
    	/*
    	$zones = CamaraStaticHelper::getZones($id);
	    dd($zones);
        */
    	$lector = Lector::find($id);
    	return view('app.portico.show', array(
    		'id' => $id,
		    'lector' => $lector
	    ));

    }

    public function report($id, $report_id)
    {
    	switch ($report_id) {
		    case "1":
		    	return view('app.portico.report.first', array('title' => 'Autos día'));
		    break;
		    case "2":
		    	return view('app.portico.report.second', array('title' => 'Tipo de Vehículo'));
		    break;
		    case "3":
		    	return view('app.portico.report.third');
		    break;
		    case "4":
		    	return view('app.portico.report.fourth');
		    break;
		    default:
		    	break;
	    }
    }
}
