<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Vehiculo;
use DB;
use Illuminate\Http\Request;

use App\Http\Requests;

class VehiculoController extends Controller
{
    public function index()
    {
    	$vehiculos = Vehiculo::all();

	    return view('app.vehiculos.index', [
	    	'vehiculos' =>  $vehiculos
	    ]);
    }

    public function show($id)
    {
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
		    'registro'  =>  $registro
	    ]);
    }
}
