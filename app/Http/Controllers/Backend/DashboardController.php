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
        // $this->route = 'dashboard';
    }

    public function index()
    {
        $appVars = \App\Models\AppVar::where('name', 'LIKE', "Chart %")->get(['name', 'value'])->pluck('value', 'name');
        return view('backend.dashboard.index',[
            'breadcrumbs' => $this->breadcrumbs, 'appVars' => $appVars
            // 'route' => $this->route
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

    public function chart1(){
        // dd(request()->all());
        $record = KeluhanPelanggan::with('history')->select('*');

        if($ruas_id = request()->ruas_id){
            $record->where('ruas_id',$ruas_id);            
        }

        if($regional_id = request()->regional_id){
        
            $record->where('regional_id',$regional_id);        
        }

        if($month = request()->month){
        
            $record->whereMonth('tanggal_kejadian',$month);        
        }

        if($year = request()->year){
        
            $record->whereDate('tanggal_kejadian',$year);        
        }

        $record = $record->get();

        if($record->count() > 0){
            foreach($record as $k => $value){
                dd($value->tanggal_kejadian->format('Y'));
            }
        }
    }
}
