<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;

use App\Http\Requests;

class IncidenciasController extends Controller
{
    public function index()
    {
    	$incidencias = Incidencia::all();
    	return view('app.incidencias.index')->with(array(
    		'incidencias'   =>  $incidencias
	    ));
    }
}
