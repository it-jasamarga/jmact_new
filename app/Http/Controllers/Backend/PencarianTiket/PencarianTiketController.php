<?php

namespace App\Http\Controllers\Backend\PencarianTiket;

use App\Http\Controllers\Controller;
use App\Models\Cartik;
// use App\Models\KeluhanPelanggan;
// use App\Models\ClaimPelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Filters\KeluhanPelangganFilter;
// use App\Filters\ClaimPelangganFilter;
use App\Filters\CartikFilter;
use App\Http\Requests\MasterBkRequest;

class PencarianTiketController extends Controller
{
    private $route = 'pencarian-tiket';

    public $breadcrumbs = [
        ['name' => "Pencarian Tiket"], 
        ['link' => "#", 'name' => "Pencarian Tiket"],
        ['link' => "pencarian-tiket", 'name' => "Pencarian Tiket"]
    ];

    public function __construct() {
      $this->middleware(function ($request, $next) {
        $can_cartik = auth()->user()->hasPermissionTo('pencarian-tiket.detail') || auth()->user()->hasPermissionTo('pencarian-tiket.expand');
        try { if (! auth()->user()->hasPermissionTo($request->route()->getName())) abort(403); }
        catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist $e) { if (! $can_cartik) abort(403); }
        return $next($request);
      });

    }
    
    public function index(Request $request) {
        $data = [
            'title' => 'Pencarian Tiket',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
        ];
        return view('backend.pencarian-tiket.index', $data);
    }

    public function list(CartikFilter $request) {
        // dd($request);
        // $kp = KeluhanPelanggan::select('no_tiket', 'status_id', DB::raw("'K' AS type"))->filter(new KeluhanPelangganFilter($request));
        // $cp = ClaimPelanggan::select('no_tiket', 'status_id', DB::raw("'C' AS type"))->filter(new ClaimPelangganFilter($request));
        
        // $kp = KeluhanPelanggan::query()->filter($request);
        // $cp = ClaimPelanggan::query()->filter($request);

        // dd($kp, $cp);

        
        $data  = Cartik::query()->filter($request);
        // dd($kp, $cp, $data);



        return datatables()->of($data)
        ->addColumn('status_id', function ($data) use ($request) { return ($data->status) ? $data->status->status : '-'; })
        ->addColumn('type_id', function ($data) use ($request) { return ($data->type == 'K') ? "Keluhan" : "Claim"; })   // TODO: there must be somethin todo
        // ->addColumn('action', function($data){ return '
        // <a href="keluhan/'.$data->id.'" class="symbol-label font-size-h5 font-weight-bold"><i class="flaticon2-list-1 btn btn-icon btn-info btn-sm btn-hover-light"></i></a>
        // <span style="margin: 0 2px"></span>
        // <a href="#" onclick="ticket.detail.open(this)" class="symbol-label font-size-h5 font-weight-bold"><i class="flaticon2-arrow-down btn btn-icon btn-success btn-sm btn-hover-light"></i></a>
        // ';})
        ->addColumn('action', function($data){
            $buttons = "";
            if(auth()->user()->can('pencarian-tiket.detail')) {
              $buttons .= makeButton([
                'type' => 'url',
                'url'   => ($data->type=='K' ? 'keluhan/' : 'claim/').$data->id,
                'class'   => 'btn btn-icon btn-info btn-sm btn-hover-light',
                'label'   => '<i class="flaticon2-list-1"></i>',
                'tooltip' => 'Detail Data'
              ]);
            }
            
            if(auth()->user()->can('pencarian-tiket.expand')) {
              $buttons .= makeButton([
                'type' => 'url',
                'url' => '#',
                'onClick'   => 'ticket.detail.open(this)',
                'class'   => 'btn btn-icon btn-success btn-sm btn-hover-light',
                'label'   => '<i class="flaticon2-arrow-down"></i>',
                'tooltip' => 'Histori'
              ]);
            }
            
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
