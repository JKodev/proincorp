<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function index()
    {
    	$users = User::all();
		return view('app.user.index', array(
			'users' =>  $users
		));
    }

    public function create()
    {
    	$permissions = Permission::all();
    	return view('app.user.create')->with('permissions', $permissions);
    }

    public function store(Request $request)
    {
		dd($request->all());
    }
}
