<?php

namespace App\Http\Controllers;

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
}
