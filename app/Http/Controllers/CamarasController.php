<?php

namespace App\Http\Controllers;

use App\Models\Camara;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;

class CamarasController extends Controller
{
	private $colors = ["green-jungle", "blue-sharp", "red-thunderbird", "yellow-gold", "purple-seance", "blue-ebonyclay", "green-turquoise", "grey-salsa", "red-sunglo", "yellow-soft", "purple-medium"];
    public function index()
    {
    	$camaras = Camara::where('currentConfigurationIndex', -99)->get();

	    return view('app.camaras.index', [
	    	'camaras'   =>  $camaras,
		    'colors'    =>  $this->colors
	    ]);
    }

    public function show($id)
    {
    	$camaras = Camara::where('currentConfigurationIndex', -99)->get();
    	$camara = Camara::find($id);

	    $cam_ubication = DB::connection('sqlsrv')
		    ->table('TBL_CAMARA_UBICACION')
		    ->where('cod_camara', $camara->id)
	        ->first();

	    if ($cam_ubication !== null) {
		    $ubicacion = DB::connection('sqlsrv')
			    ->table('TB_UBICACION')
			    ->where('codigo', $cam_ubication->cod_ubicacion)
			    ->first();
	    } else {
	    	$ubicacion = null;
	    }

	    return view('app.camaras.show', [
	    	'camaras'   =>  $camaras,
		    'camara'    =>  $camara,
		    'ubicacion' =>  $ubicacion,
		    'colors'    =>  $this->colors
	    ]);
    }
}
