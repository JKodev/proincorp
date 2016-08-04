<?php

namespace App\Http\Controllers;

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
