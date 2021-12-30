<?php

namespace App\Http\Controllers\Backend\PencarianTiket;

use App\Http\Controllers\Controller;
// use App\Models\Tiket;
use App\Models\KeluhanPelanggan;
use Illuminate\Http\Request;

use App\Filters\KeluhanPelangganFilter;
use App\Http\Requests\MasterBkRequest;

class PencarianTiketController extends Controller
{
    //
    public $breadcrumbs = [
        ['name' => "Manage Pencarian Tiket"], 
        ['link' => "#", 'name' => "PencarianTiket"],
        ['link' => "pencarian-tiket", 'name' => "Pencarian Tiket"]
    ];

    public function __construct() {
        $this->route = 'pencarian-tiket';
    }
    
    public function index(Request $request) {
        $data = [
            'title' => 'Pencarian Tiket',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
        ];
        return view('backend.pencarian-tiket.index', $data);
    }

    public function list(KeluhanPelangganFilter $request) {
        $data  = KeluhanPelanggan::query()->filter($request);
        return datatables()->of($data)
        ->addColumn('status_id', function ($data) use ($request) { return ($data->status) ? $data->status->status : '-'; })
        ->addColumn('type_id', function ($data) use ($request) { return "Keluhan"; })   // TODO: there must be somethin todo
        ->addColumn('action', function($data){ return '
        <a href="/keluhan/'.$data->id.'" class="symbol-label font-size-h5 font-weight-bold"><i class="flaticon2-list-1"></i></a>
        <span style="margin: 0 2px"></span>
        <a href="#" onclick="ticket.detail.open(this)" class="symbol-label font-size-h5 font-weight-bold"><i class="flaticon2-arrow-down"></i></a>
';})
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }
}
