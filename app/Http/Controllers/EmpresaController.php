<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index()
    {
    	$empresas = Empresa::all();
    	//dd($empresa);
    	return view('app.empresa.index', array(
    		'empresas' => $empresas
    	));
    }

    public function report($id)
    {
    	$empresa = Empresa::where('ID_Empresa', $id)->get();

	    return view('app.empresa.report', array(
	    	'empresa' => $empresa
	    ));
    }
}
