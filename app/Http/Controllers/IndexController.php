<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{

    public function __construct()
    {
        $this->middleware('web');
    }

    public function index()
    {
        // $devices = \DB::table('sessions')
        //     ->where('user_id', \Auth::user()->id)
        //     ->get()->reverse();
        // $current_session_id = \Session::getId();
        // $page_title         = 'Dashboard';
        // $page_description   = 'Main Dashboard';

        return view('backend.dashboard.index');
    }
}
