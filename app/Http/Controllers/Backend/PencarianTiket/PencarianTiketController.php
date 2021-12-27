<?php

namespace App\Http\Controllers\Backend\PencarianTiket;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Illuminate\Http\Request;

use App\Filters\PencarianTiketFilter;
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

    public function list(PencarianTiketFilter $request) {

        $data  = Tiket::query()->filter($request);

        return datatables()->of($data)
        ->addColumn('numSelect', function ($data) use ($request) {
        $button = '';
        $button .= makeButton([
            'type' => 'deleteAll',
            'value' => $data->id
        ]);
        return $button;
        })
        ->addColumn('active', function ($data) use ($request) {
        $button = getActive($data->active);
        return $button;
        })
        ->addColumn('action', function($data){
        $buttons = "";
        $buttons .= makeButton([
            'type' => 'modal',
            'url'   => $this->route.'/'.$data->id.'/edit'
        ]);
        return $buttons;
        })
        // ->rawColumns(['numSelect','action'])
        ->addIndexColumn()
        ->make(true);

    }
}
