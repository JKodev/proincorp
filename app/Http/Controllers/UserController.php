<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;

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
	    $users = User::all();
    	return view('app.user.create')->with(array(
    		'permissions'   =>  $permissions,
	        'users' =>  $users
	    ));
    }

    public function store(Request $request)
    {
    	$rules = array(
    		'name'  =>  'required',
		    'email' =>  'required|email',
		    'password'  =>  'required'
	    );

	    $validator = Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
	    	return \Redirect::route('app.settings.users.create')
			    ->withErrors($validator)
			    ->withInput($request->except('password'));
	    } else {
	    	$user = new User();
		    $user->name = $request->name;
		    $user->email = $request->email;
		    $user->password = bcrypt($request->password);
		    $user->save();

		    foreach ($request->permissions as $permission) {
		    	$perm = Permission::find($permission);
		    	$user->attachPermission($perm);
		    }

		    \Session::flash('message', "Usuario creado correctamente.");
		    return \Redirect::route('app.settings.users.index');
	    }

    }
}
