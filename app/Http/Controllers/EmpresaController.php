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
}
