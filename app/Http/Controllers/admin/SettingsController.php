<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;

class SettingsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
    	return view('admin_v2.settings.settings');
    }
}
