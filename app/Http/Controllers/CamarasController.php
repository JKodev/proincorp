<?php

namespace App\Http\Controllers;

use App\Models\Camara;
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
}
