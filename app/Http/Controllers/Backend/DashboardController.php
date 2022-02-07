<?php

namespace App\Http\Controllers\Backend;

use App\Filters\KeluhanPelangganFilter;
use App\Http\Controllers\Controller;
use App\Models\KeluhanPelanggan;

use Illuminate\Support\Facades\DB;

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

        $query = DB::table('keluhan')
        ->select(
            'master_regional.name AS regional', 'master_ruas.name AS ruas',
            DB::raw('COUNT(keluhan.no_tiket) AS total'),
        )
        ->leftJoin('master_ruas', 'master_ruas.id', '=', 'keluhan.ruas_id')
        ->leftJoin('master_ro', 'master_ro.id', '=', 'master_ruas.ro_id')
        ->leftJoin('master_regional', 'master_regional.id', '=', 'master_ro.regional_id')
        ->where('keluhan.status_id', '>=', DB::raw('(SELECT id FROM master_status WHERE status="On Progress" AND type=1)'))
        ->where('keluhan.status_id', '<', DB::raw('(SELECT id FROM master_status WHERE status="Closed" AND type=1)'))
        ->groupBy('master_regional.name', 'master_ruas.name', 'keluhan.status_id')
        ->get();

        $overtime = ['total' => $query->sum('total')];
        $regionals = \App\Models\MasterRegional::get(['name'])->pluck('name')->toArray();
        foreach ($regionals as $regional) {
            $overtime['regional'][$regional] = [
                'total' => $query->where('regional', $regional)->sum('total'),
                'ruas' => $query->where('regional', $regional)->pluck('total', 'ruas')->toArray()
            ];
        }

        // dd($overtime, $query->toArray());

        return view('backend.dashboard.index',[
            'breadcrumbs' => $this->breadcrumbs, 'appVars' => $appVars, 'overtime' => $overtime
            // 'route' => $this->route
        ]);
    }

    // public function list(KeluhanPelangganFilter $request) {

    //     $data  = KeluhanPelanggan::query()->filter($request);

    //     return datatables()->of($data)
    //     ->addColumn('numSelect', function ($data) use ($request) {
    //         $button = '';
    //         $button .= makeButton([
    //           'type' => 'deleteAll',
    //           'value' => $data->id
    //         ]);
    //         return $button;
    //       })
    //     ->addColumn('regional_id', function ($data) use ($request) {
    //         $button = ($data->regional) ? $data->regional->name : '-';
    //         return $button;
    //     })
    //     ->addColumn('user_id', function ($data) use ($request) {
    //         $button = ($data->user) ? $data->user->name : '-';
    //         return $button;
    //     })
    //     ->addColumn('sumber_id', function ($data) use ($request) {
    //         $button = ($data->sumber) ? $data->sumber->description : '-';
    //         return $button;
    //     })
    //     ->addColumn('ruas_id', function ($data) use ($request) {
    //         $button = ($data->ruas) ? $data->ruas->name : '-';
    //         return $button;
    //     })
    //     ->addColumn('status_id', function ($data) use ($request) {
    //     $button = ($data->status) ? $data->status->status : '-';
    //     return $button;
    //     })
    //     ->rawColumns(['numSelect','action'])
    //     ->addIndexColumn()
    //     ->make(true);

    // }

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
