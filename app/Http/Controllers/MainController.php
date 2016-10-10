<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class MainController extends Controller
{
    //
	public function index(){
	
		$users = User::orderBy('created_at', 'asc')->paginate(5);
		return view('index')->with('users', $users);

	}
}
