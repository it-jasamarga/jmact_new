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
        ['name' => "Pencarian Tiket"], 
        ['link' => "#", 'name' => "Pencarian Tiket"],
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
        // ->addColumn('action', function($data){ return '
        // <a href="keluhan/'.$data->id.'" class="symbol-label font-size-h5 font-weight-bold"><i class="flaticon2-list-1 btn btn-icon btn-info btn-sm btn-hover-light"></i></a>
        // <span style="margin: 0 2px"></span>
        // <a href="#" onclick="ticket.detail.open(this)" class="symbol-label font-size-h5 font-weight-bold"><i class="flaticon2-arrow-down btn btn-icon btn-success btn-sm btn-hover-light"></i></a>
        // ';})
        ->addColumn('action', function($data){
            $buttons = "";
            $buttons .= makeButton([
              'type' => 'url',
              'url'   => $this->route.'/'.$data->id.'',
              'class'   => 'btn btn-icon btn-info btn-sm btn-hover-light',
              'label'   => '<i class="flaticon2-list-1"></i>',
              'tooltip' => 'Detail Data'
            ]);
            
            $buttons .= makeButton([
              'type' => 'url',
              'url' => '#',
              'onClick'   => 'ticket.detail.open(this)',
              'class'   => 'btn btn-icon btn-success btn-sm btn-hover-light',
              'label'   => '<i class="flaticon2-arrow-down"></i>'
            ]);
            
            return $buttons;
          })
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }

    public function show($id) {
        $record = KeluhanPelanggan::findOrFail($id);
    
        $data =[
          'title' => 'Detail Data Keluhan',
          'breadcrumbs' => $this->breadcrumbs,
          'route' => $this->route,
          'record' => $record
        ];
        
        return view('backend.pencarian-tiket.show', $data);
    }

}
