<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
class DashboardController extends Controller
{
    public $breadcrumbs = [
        ['name' => "Manage Role"], 
        ['link' => "/", 'name' => "Dashboard"], 
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('backend.dashboard.index',[
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}
