<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
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
}
