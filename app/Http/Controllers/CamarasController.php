<?php

namespace App\Http\Controllers;

use App\Models\Camara;
use Illuminate\Http\Request;

use App\Http\Requests;

class CamarasController extends Controller
{
    public function index()
    {
    	$camaras = Camara::all();

	    return view();
    }
}
