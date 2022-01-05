<?php

namespace App\Http\Controllers\Backend;

use App\Filters\KeluhanPelangganFilter;
use App\Http\Controllers\Controller;
use App\Models\KeluhanPelanggan;

class DashboardController extends Controller
{
    public $breadcrumbs = [
        ['name' => "Dashboard"], 
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

    public function list(KeluhanPelangganFilter $request) {

        $data  = KeluhanPelanggan::query()->filter($request);

        return datatables()->of($data)
        ->addColumn('numSelect', function ($data) use ($request) {
            $button = '';
            $button .= makeButton([
              'type' => 'deleteAll',
              'value' => $data->id
            ]);
            return $button;
          })
        ->addColumn('regional_id', function ($data) use ($request) {
            $button = ($data->regional) ? $data->regional->name : '-';
            return $button;
        })
        ->addColumn('user_id', function ($data) use ($request) {
            $button = ($data->user) ? $data->user->name : '-';
            return $button;
        })
        ->addColumn('sumber_id', function ($data) use ($request) {
            $button = ($data->sumber) ? $data->sumber->description : '-';
            return $button;
        })
        ->addColumn('ruas_id', function ($data) use ($request) {
            $button = ($data->ruas) ? $data->ruas->name : '-';
            return $button;
        })
        ->addColumn('status_id', function ($data) use ($request) {
        $button = ($data->status) ? $data->status->status : '-';
        return $button;
        })
        ->rawColumns(['numSelect','action'])
        ->addIndexColumn()
        ->make(true);

    }
}
