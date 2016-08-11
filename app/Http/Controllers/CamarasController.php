<?php

namespace App\Http\Controllers;

use App\Models\Camara;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;

class CamarasController extends Controller
{
    public function index()
    {
    	$camaras = Camara::where('currentConfigurationIndex', -99)->get();

	    return view('app.camaras.index', [
	    	'camaras'   =>  $camaras
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

	    $ubicacion = DB::connection('sqlsrv')
		    ->table('TB_UBICACION')
		    ->where('codigo', $cam_ubication->cod_ubicacion)
		    ->first();

	    return view('app.camaras.show', [
		    'camara'    =>  $camara,
		    'ubicacion' =>  $ubicacion
	    ]);
    }
}
