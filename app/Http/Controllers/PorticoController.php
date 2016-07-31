<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Camara;

class PorticoController extends Controller
{
    public function index()
    {
    	$colors = ["green-jungle", "blue-sharp", "red-thunderbird", "yellow-gold", "purple-seance", "blue-ebonyclay", "green-tuorquoise", "gray-salsa", "red-sunglo", "yellow-soft", "purple-medium"];
    	$camaras = Camara::where('currentConfigurationIndex', '-99')->orderBy('cameraName', 'ASC')->get();
    	return view('app.portico.index', array(
    		'camaras' => $camaras,
    		'colors' => $colors
    	));
    }

    public function show($id)
    {
        return view('app.portico.show');
    }

    public function report($id, $report_id)
    {
    	switch ($report_id) {
		    case 1:
		    	return view('app.portico.report.first', array('title' => 'Autos día'));
		    break;
		    case 2:
		    	return view('app.portico.report.second', array('title' => 'Tipo de Vehículo'));
		    break;
		    case 3:
		    	return view('app.portico.report.third');
		    break;
		    case 4:
		    	return view('app.portico.report.fourth');
		    break;
		    default:
		    	break;
	    }
    }
}
