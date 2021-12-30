<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

use App\Models\KeluhanPelanggan;
use App\Models\MasterStatus;

use App\Filters\KeluhanPelangganFilter;
use App\Http\Requests\KeluhanPelangganRequest;
use App\Http\Requests\KeluhanHistoryRequest;
use App\Http\Requests\KeluhanReportRequest;

use App\Helpers\HelperFirestore;
use App\Models\MasterRuas;
use DB;
use Carbon\Carbon;
class KeluhanController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Keluhan"], 
    ['link' => "#", 'name' => "Laporan Pelanggan"],
    ['link' => "keluhan", 'name' => "Keluhan"]
  ];

  public function __construct(){
    $this->route = 'keluhan';
    // $this->firebase = new HelperFirestore();
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Filter Data Keluhan',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.laporan.keluhan.index', $data);
  }

  public function list(KeluhanPelangganFilter $request)
  {

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
    ->addColumn('ruas_id', function ($data) use ($request) {
        $button = ($data->ruas) ? $data->ruas->name : '-';
        return $button;
    })
    ->addColumn('sumber_id', function ($data) use ($request) {
        $button = ($data->sumber) ? $data->sumber->description : '-';
        return $button;
    })
    ->addColumn('bidang_id', function ($data) use ($request) {
        $button = ($data->bidang) ? $data->bidang->bidang : '-';
        return $button;
    })
    ->addColumn('status_id', function ($data) use ($request) {
      $button = ($data->status) ? $data->status->status : '-';
      return $button;
    })
    ->addColumn('golongan_id', function ($data) use ($request) {
        $button = ($data->golongan) ? $data->golongan->golongan : '-';
        return $button;
    })
    ->addColumn('action', function($data){
      $buttons = "";
      $buttons .= makeButton([
        'type' => 'modal',
        'url'   => $this->route.'/'.$data->id.'/edit',
        'class'   => 'btn btn-icon btn-warning btn-sm btn-hover-light custome-modal',
        'label'   => '<i class="flaticon2-paperplane"></i>',
        'tooltip' => 'Teruskan'
      ]);
    
      $buttons .= makeButton([
        'type' => 'url',
        'url'   => $this->route.'/sla/'.$data->id.'',
        'class'   => 'btn btn-icon btn-success btn-sm btn-hover-light',
        'label'   => '<i class="flaticon2-list-1"></i>',
        'tooltip' => 'SLA'
      ]);
      
      $buttons .= makeButton([
        'type' => 'url',
        'url'   => $this->route.'/'.$data->id.'',
        'class'   => 'btn btn-icon btn-info btn-sm btn-hover-light',
        'label'   => '<i class="flaticon2-list-1"></i>',
        'tooltip' => 'Detail Data'
      ]);
      return $buttons;
    })
    ->rawColumns(['numSelect','action'])
    ->addIndexColumn()
    ->make(true);

  }

  
  public function create()
  {
    $data = [
        'title' => 'Buat Data Keluhan',
        'breadcrumbs' => $this->breadcrumbs,
        'route' => $this->route,
      ];
    
    return view('backend.laporan.keluhan.create', $data);
  }

  public function store(KeluhanPelangganRequest $request){
    DB::beginTransaction();
    try {
      $dataRuas = MasterRuas::find($request->ruas_id);
      
      if($dataRuas) {
        $dataRo = $dataRuas->ro;
        if ($dataRo) {
          $dataRegional = $dataRo->regional;
          if ($dataRegional) {
            $request['regional_id'] = $dataRegional->id;
          }
        }
      }

      $request['user_id'] = auth()->user()->id;
      $request['status_id'] = MasterStatus::where('code','01')->first()->id;

      $record = KeluhanPelanggan::saveData($request);
      $record->no_tiket = getTiket($record);
      $record->save();
      $record->keluhanUnit()->create([
        'unit_id' => $record->unit_id,
        'created_by' => $request->user_id
      ]);
      
      // $this->firebase->sendGroup(
      //   $record, 
      //   'JMACT - Keluhan Kepada '.$record->unit->unit, 
      //   'Proses Keluhan Dengan No Tiket '.$record->no_tiket
      // );
      
      $record->history()->create([
        'ruas_id' => $record->ruas_id,
        'regional_id' => $record->regional_id,
        'unit_id' => $record->unit_id,
        'status_id' => MasterStatus::where('code','01')->first()->id
      ]);
      DB::commit();
      return response([
        'status' => true,
        'message' => 'success',
      ]);

    } catch (\Exception $e) {
      DB::rollback();
      return response([
        'message' => $e->getMessage(),
      ], 500);
    } catch (\Illuminate\Database\QueryException $e) {
      DB::rollback();
      return response([
        'message' => $e->getMessage(),
      ], 500);
    }
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => KeluhanPelanggan::findOrFail($id)
    ];

    return view('backend.laporan.keluhan.edit', $data);
  }

  public function history(KeluhanHistoryRequest $request, $id){
    $record = KeluhanPelanggan::findOrFail($id);
    
    $request['status_id'] = MasterStatus::where('code','03')->first()->id;
    $request['unit_id'] = $record->unit_id;
    $request['regional_id'] = $record->regional_id;

    $record->status_id = $request->status_id;
    $record->save();

    $recordHistory = $record->history()->create($request->all());
    
    $name = $recordHistory->ruas->name.' - '.$recordHistory->ruas->ro->name;

    // $this->firebase->sendGroup(
    //   $record, 
    //   'JMACT - Keluhan Diteruskan Kepada Service Provider', 
    //   'Diteruskan Ke '.$name
    // );

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  // START PROSES SLA

  public function sla($id)
  {
    $record = KeluhanPelanggan::findOrFail($id);

    if(($record->mulaiSla->count() > 0) && ($record->report->count() >= 0)){
      $view = 'backend.laporan.keluhan.sla.report';
    }else{
      $view = 'backend.laporan.keluhan.sla.show';
    }

    $data = [
      'title' => 'SLA',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
      'record' => $record
    ];

    return view($view, $data);
  }

  public function prosesSla($id){
    request()['status_id'] = MasterStatus::where('code','05')->first()->id;
   
    $record = KeluhanPelanggan::findOrFail($id);
    $record->status_id = request()->status_id;
    $record->save();

    $record->mulaiSla()->create([
      'estimate' => 3,
      'date' => Carbon::now()->addDays(3)
    ]);

    request()['unit_id'] = $record->unit_id;
    request()['regional_id'] = $record->regional_id;
    $recordHistory = $record->history()->create(request()->all());

    // $this->firebase->sendGroup(
    //   $record, 
    //   'JMACT - Keluhan Dalam Proses SLA', 
    //   'Estimasi Proses Dalam 3 Hari'
    // );
    return response([
      'status' => true,
      'message' => 'success',
      'messageBox' => 'Keluhan Dengan No Tiket '.$record->no_tiket.' Sedang Di Proses',
    ]);
  }

  public function reportSla($id)
  {
    $record = KeluhanPelanggan::findOrFail($id);

    $data = [
      'title' => 'SLA',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
      'record' => $record
    ];

    return view('backend.laporan.keluhan.sla.report-add', $data);
  }

  public function prosesReportSla(KeluhanReportRequest $request, $id){
    $request['status_id'] = MasterStatus::where('code','06')->first()->id;

    $record = KeluhanPelanggan::findOrFail($id);
    $record->report()->create(request()->all());

    unset($request['keterangan']);
    unset($request['url_file']);
    
    
    $recordHistory = $record->history()->create([
      'unit_id' => $record->unit_id,
      'regional_id' => $record->regional_id,
      'status_id' => MasterStatus::where('code','06')->first()->id
    ]);

    // $this->firebase->send(
    //   $record, 
    //   'JMACT - Pelaporan Tiket Keluhan No Tiket'.$record->no_tiket.'', 
    //   'Pelaporan Keluhan Dengan No Tiket '.$record->no_tiket.' Telah Selesai Dikerjakan '
    // );

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  // END SLA

  public function show($id)
  {
    
    $record = KeluhanPelanggan::findOrFail($id);

    $data =[
      'title' => 'Detail Data Keluhan',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
      'record' => $record
    ];
    
    return view('backend.laporan.keluhan.show', $data);
  }

  public function update(KeluhanPelangganRequest $request, $id){
    $record = KeluhanPelanggan::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = KeluhanPelanggan::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = KeluhanPelanggan::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
