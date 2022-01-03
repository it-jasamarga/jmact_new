<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Filters\ClaimPelangganFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClaimHistoryRequest;
use App\Http\Requests\ClaimPelangganRequest;
use App\Models\ClaimPelanggan;
use App\Models\MasterRuas;
use App\Models\MasterStatus;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class ClaimController extends Controller
{
    public $breadcrumbs = [
      ['name' => "Laporan Claim Pelanggan"], 
      ['link' => "#", 'name' => "Laporan Pelanggan"],
      ['link' => "claim", 'name' => "Claim"]
    ];
    
    public function __construct() {
        $this->route = 'claim';
    }
    
    public function index(Request $request) {
      $data = [
        'title' => 'Filter Data Claim',
        'breadcrumbs' => $this->breadcrumbs,
        'route' => $this->route,
      ];
  
      return view('backend.laporan.claim.index', $data);
    }

    public function list(ClaimPelangganFilter $request) {

    $data  = ClaimPelanggan::query()->filter($request);

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

  public function create() {
    $data = [
        'title' => 'Buat Data Claim',
        'breadcrumbs' => $this->breadcrumbs,
        'route' => $this->route,
      ];
    
    return view('backend.laporan.claim.create', $data);
  }

  public function store(ClaimPelangganRequest $request){
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

      $record = ClaimPelanggan::saveData($request);
      $record->no_tiket = getTiketClaim($record);
      $record->save();
      // $record->keluhanUnit()->create([
      //   'unit_id' => $record->unit_id,
      //   'created_by' => $request->user_id
      // ]);
      
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
      'record' => ClaimPelanggan::findOrFail($id)
    ];

    return view('backend.laporan.claim.edit', $data);
  }

  public function history(ClaimHistoryRequest $request, $id) {
    $record = ClaimPelanggan::findOrFail($id);
    
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

  public function show($id) {
    
    $record = ClaimPelanggan::findOrFail($id);

    $data =[
      'title' => 'Detail Data Claim',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
      'record' => $record
    ];
    
    return view('backend.laporan.claim.show', $data);
  }

}
