<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PorticoController extends Controller
{
    public function index()
    {
    	return view('app.portico.index');
    }

    public function show($id)
    {
        return view('app.portico.show');
    }
}
