<?php

namespace App\Http\Controllers\Backend\Laporan;

use App\Filters\ClaimPelangganFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\DetailHistoryRequest;
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
        'title' => 'Claim',
        'breadcrumbs' => $this->breadcrumbs,
        'route' => $this->route,
      ];
  
      return view('backend.laporan.claim.index', $data);
    }

    public function list(ClaimPelangganFilter $request) {

    $data  = ClaimPelanggan::query()->orderByDesc('created_at')->filter($request);

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

      if(auth()->user()->can('claim.forward')) {
        $buttons .= makeButton([
          'type' => 'modal',
          'url'   => $this->route.'/'.$data->id.'/edit',
          'class'   => 'btn btn-icon btn-warning btn-sm btn-hover-light custome-modal',
          'label'   => '<i class="flaticon2-paperplane"></i>',
          'tooltip' => 'Teruskan'
        ]);
      }

      if(auth()->user()->can('claim.stage')) {
        $buttons .= makeButton([
          'type' => 'modal',
          'url'   => $this->route.'/'.$data->id.'/edit-stage',
          'class'   => 'btn btn-icon btn-success btn-sm btn-hover-light custome-modal',
          'label'   => '<i class="flaticon2-checking"></i>',
          'tooltip' => 'Tahapan'
        ]);
      }

      if(auth()->user()->can('claim.detail')) {
        $buttons .= makeButton([
          'type' => 'url',
          'url'   => $this->route.'/'.$data->id.'',
          'class'   => 'btn btn-icon btn-info btn-sm btn-hover-light',
          'label'   => '<i class="flaticon2-list-1"></i>',
          'tooltip' => 'Detail'
        ]);
      }
      
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
    $recordData =  ClaimPelanggan::select('*');
    $noData = 0;
    if ($request->nama_pelanggan) {
      $recordData->where('nama_pelanggan', $request->nama_pelanggan);
      $noData += 1;
    }
    if ($request->no_telepon) {
      $recordData->where('no_telepon', $request->no_telepon);
      $noData += 1;
    }
    if ($request->tanggal_kejadian) {
      $recordData->where('tanggal_kejadian', $request->tanggal_kejadian);
      $noData += 1;
    }
    if ($request->jenis_claim_id) {
      $recordData->where('jenis_claim_id', $request->jenis_claim_id);
      $noData += 1;
    }
    if ($request->ruas_id) {
      $recordData->where('ruas_id', $request->ruas_id);
      $noData += 1;
    }

    if ($noData == 5) {
      $noTiket = $recordData->first()->no_tiket;
      // $noTiket = makeButton([
      //   'type' => 'url',
      //   'class' => 'btn btn-link mb-5 p-0',
      //   'url'  => $this->route.'/'.$recordData->first()->id.'',
      //   'label' => $recordData->first()->no_tiket,
      // ]);
      return response([
        'messageBox' => 'Claim sedang di proses dengan no tiket '.$noTiket.'',
        // 'messageBox' => "Keluhan Ini Sedang Di Proses No Tiket <a href='."url('keluhan/'.$recordData->first()->id)".'>".$recordData->first()->no_tiket."</a>",
      ], 412);
    }

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
      $request['status_id'] = MasterStatus::where('code','01')->where('type', 2)->first()->id;

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
        'status_id' => MasterStatus::where('code','01')->where('type', 2)->first()->id
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

  public function history(DetailHistoryRequest $request, $id) {
    $record = ClaimPelanggan::findOrFail($id);
    
    $request['status_id'] = MasterStatus::where('code','03')->where('type', 2)->first()->id;
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

  public function editStage($id) {

    $data = [
      'route' => $this->route,
      'record' => ClaimPelanggan::findOrFail($id)
    ];

    return view('backend.laporan.claim.edit-stage', $data);
  }

  public function historyStage(DetailHistoryRequest $request, $id) {
    $record = ClaimPelanggan::findOrFail($id);
    
    $request['status_id'] = MasterStatus::where('code','03')->where('type', 2)->first()->id;
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
