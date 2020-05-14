<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Grofie\User;

class UserController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$users = User::orderBy('id', 'DESC')->get(); 
    	return view('admin_v2.user.index',['users' => $users]);
    }
}
