<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
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

		    $rol = new Role();
		    $rol->name = $request->name;
		    $rol->display_name = $request->name;
		    $rol->description = "Rol creado para ".$request->name;
		    $rol->save();

		    $user->attachRole($rol);

		    foreach ($request->permissions as $permission) {
		    	$perm = Permission::find($permission);
		    	$rol->attachPermission($perm);
		    }

		    \Session::flash('message', "Usuario creado correctamente.");
		    return \Redirect::route('app.settings.users.index');
	    }

    }

    public function edit($id)
    {
		$user = User::find($id);

	    if (is_null($user)) {
	    	return redirect()->route('app.settings.users.index');
	    }

	    $permissions = Permission::all();

	    return view('app.user.edit')->with(array(
	    	'user'  =>  $user,
		    'permissions'   =>  $permissions
	    ));
    }

    public function update(Request $request, $id)
    {
	    $rules = array(
		    'name'  =>  'required',
		    'email' =>  'required|email'
	    );

	    $validator = Validator::make($request->all(), $rules);

	    if ($validator->fails()) {
		    return \Redirect::route('app.settings.users.update', array('id'=>$id))
			    ->withErrors($validator)
			    ->withInput($request->except('password'));
	    }

	    $user = User::find($id);

	    if (is_null($user)) {
		    return redirect()->route('app.settings.users.index');
	    }

        $user->name = $request->input('name');
	    $user->email = $request->input('email');
	    if (!empty($request->input('password'))) {
	        $user->password = bcrypt($request->input('password'));
	    }
	    $user->save();

	    $rol = $user->roles()->first();

        $permissions = $request->input('permissions', []);

	    if (is_null($rol)) {
		    $rol = new Role();
		    $rol->name = $user->name;
		    $rol->display_name = $user->name;
		    $rol->description = "Rol creado para ".$request->name;
		    $rol->save();

		    $user->attachRole($rol);
	    }

	    $rol->perms()->sync([]);

	    if (count($permissions) > 0) {
			foreach ($permissions as $permission) {
				$perm = Permission::find($permission);
				$rol->attachPermission($perm);
			}
	    }

	    \Session::flash('message', "Usuario actualizado correctamente.");
	    return \Redirect::route('app.settings.users.index');
    }

    public function destroy($id)
    {
		$user = User::find($id);

	    $roles = $user->roles()->get();

	    foreach ($roles as $role) {
	    	/** @var Role $rol */
	    	//$rol = Role::findOrFail($role->id);
		    $role->users()->sync([]);
		    $role->perms()->sync([]);
		    $role->forceDelete();
	    }

	    if (!is_null($user))
	    	$user->delete();

		\Session::flash('message', 'Se ha eliminado al usuario.');
	    return redirect()->route('app.settings.users.index');
    }
}
