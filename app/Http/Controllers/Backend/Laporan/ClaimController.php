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
    $tglKejadian = Carbon::parse($request->tanggal_kejadian)->format('Y-m-d');
    $recordData =  ClaimPelanggan::where(DB::raw('UPPER(nama_pelanggan)'), 'like', '%'.strtoupper($request->nama_pelanggan).'%')
    ->where('no_telepon', $request->no_telepon)
    ->whereDate('tanggal_kejadian', $tglKejadian)
    ->where('jenis_claim_id', $request->jenis_claim_id)
    ->where('ruas_id', $request->ruas_id)->first();

    if ($recordData) {
      $noTiket = ($recordData) ? $recordData->no_tiket : '-';
      $idData = ($recordData) ? $recordData->id : '-';
      return response([
        'messageBox' => "Claim sedang di proses dengan no tiket <a href='".url('claim/'.$idData)."'>".$noTiket."</a>",
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

  public function historyStage(Request $request, $id) {
    // dd(request()->all());
    $record = ClaimPelanggan::findOrFail($id);
    
    $request['status_id'] = MasterStatus::where('code',$request->status)->where('type', 2)->first()->id;
    $request['unit_id'] = $record->unit_id;
    $request['regional_id'] = $record->regional_id;
    if ($request->nominal_final) {
      $record->nominal_final = $request->nominal_final;
    }

    $record->status_id = $request->status_id;
    $record->save();

    unset($request['status']);
    unset($request['nominal_final']);
    $recordHistory = $record->history()->create($request->all());
    
    // $name = $recordHistory->ruas->name.' - '.$recordHistory->ruas->ro->name;

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

  public function claimDetail($id) {
    $status = MasterStatus::where('code', request()->status)->where('type', 2)->first();

    $record = ClaimPelanggan::findOrFail($id);
    
    $record->status_id = $status->id;

    if (request()->keterangan_reject) {
      $record->keterangan_reject = request()->keterangan_reject;
    }

    $record->save();

    $data['status_id'] = $status->id;
    $data['unit_id'] = $record->unit_id;
    $data['regional_id'] = $record->regional_id;

    $recordHistory = $record->history()->create($data);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
    
  }
  
  public function claimReject($id) {
    $record = ClaimPelanggan::findOrFail($id);

    $data = [
      'title' => 'Reject Claim',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
      'record' => $record
    ];

    return view('backend.laporan.claim.reject', $data);
  }

}
