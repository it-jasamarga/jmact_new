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
use App\Helpers\HelperFirestore;

class ClaimController extends Controller
{
    // private $route = 'claim';

    public $breadcrumbs = [
        ['name' => "Laporan Klaim Pelanggan"],
        ['link' => "#", 'name' => "Laporan Pelanggan"],
        ['link' => "claim", 'name' => "Klaim"]
    ];

    public function __construct()
    {
        $this->route = 'claim';
        $this->firebase = new HelperFirestore();
        // $this->middleware(function ($request, $next) {
        //     $claim = (auth()->user()->hasPermissionTo('claim.create') || auth()->user()->hasPermissionTo('claim.detail') || auth()->user()->hasPermissionTo('claim.forward') || auth()->user()->hasPermissionTo('claim.stage'));
        //     try {
        //         if (!auth()->user()->hasPermissionTo($request->route()->getName())) abort(403);
        //     } catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist $e) {
        //         if (!$claim) abort(403);
        //     }
        //     return $next($request);
        // });
    }

    public function index(Request $request)
    {
        $data = [
            'title' => 'Klaim',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
        ];

        return view('backend.laporan.claim.index', $data);
    }

    public function list(ClaimPelangganFilter $request)
    {

        // $data  = ClaimPelanggan::query()->orderByDesc('created_at')->filter($request);

        $data = ClaimPelanggan::with('history')
            ->whereHas('history', function ($q) {
                $q->where('unit_id', auth()->user()->unit_id);
            })->orderByDesc('created_at')
            ->select('*')
            ->filter($request);

        if (auth()->user()->hasRole('Superadmin')) {
            // if (auth()->user()->roles()->first()->type == "Admin") {
            $data  = ClaimPelanggan::orderByDesc('created_at')->select('*')->filter($request);
        }

        // if (auth()->user()->hasRole('JMTC')) {
        if (auth()->user()->roles()->first()->type) {
            if (auth()->user()->roles()->first()->type->type == "Supervisor JMTC") {
                $data = ClaimPelanggan::whereHas('status', function ($q1) {
                    $q1->whereIn('code', ['01', '02', '03', '04'])
                        ->where('type', 2);
                })
                    ->orderByDesc('created_at')
                    ->select('*')
                    ->filter($request);
            }
        }

        // if (auth()->user()->hasRole('Service Provider')) {
        if (auth()->user()->roles()->first()->type) {
            if (auth()->user()->roles()->first()->type->type == "Service Provider") {
                $data = ClaimPelanggan::with('history')
                    // ->where('unit_id', auth()->user()->unit_id)
                    ->whereHas('jenisClaim', function($q) {
                        $q->whereHas('unit', function($q1) {
                            $q1->where('id', auth()->user()->unit_id);
                        });
                    })
                    ->whereHas('status', function ($q2) {
                        $q2->whereIn('code', ['04', '06', '07', '08', '09', '10'])
                            ->where('type', 2);
                    })
                    ->orderByDesc('created_at')
                    ->select('*')
                    ->filter($request);
            }
        }

        // if (auth()->user()->hasRole('RO')) {
        // if (@auth()->user()->roles()->first()->ro_id) {
        if (auth()->user()->roles()->first()->type) {
            if (auth()->user()->roles()->first()->type->type == "Representative Office") {
                $roId = (auth()->user()->roles()) ? auth()->user()->roles()->first()->ro_id : null;

                $data = ClaimPelanggan::whereHas('ruas', function ($q1) use ($roId) {
                    $q1->whereHas('ro', function ($q2) use ($roId) {
                        $q2->where('id', $roId);
                    });
                })
                    ->whereHas('status', function ($q2) {
                        $q2->whereIn('code', ['02', '05', '06', '07', '08', '09', '10'])
                            ->where('type', 2);
                    })
                    ->orderByDesc('created_at')
                    ->select('*')
                    ->filter($request);
            }
        }

        // if (auth()->user()->hasRole('Regional')) {
        // if (@auth()->user()->roles()->first()->regional_id) {
        if (auth()->user()->roles()->first()->type) {
            if (auth()->user()->roles()->first()->type->type == "Regional") {
                $regionalId = (auth()->user()->roles()) ? auth()->user()->roles()->first()->regional_id : null;

                // $data  = KeluhanPelanggan::where('regional_id',$regionalId)
                $data  = ClaimPelanggan::whereHas('ruas', function ($q1) use ($regionalId) {
                    $q1->whereHas('ro', function ($q2) use ($regionalId) {
                        $q2->whereHas('regional', function ($q3) use ($regionalId) {
                            $q3->where('id', $regionalId);
                        });
                    });
                })
                    ->orderByDesc('created_at')
                    ->select('*')
                    ->filter($request);
            }
        }

        return datatables()->of($data)
            ->addColumn('numSelect', function ($data) {
                $button = '';
                $button .= makeButton([
                    'type' => 'deleteAll',
                    'value' => $data->id
                ]);
                return $button;
            })
            ->addColumn('ruas_id', function ($data) {
                $button = ($data->ruas) ? $data->ruas->name : '-';
                return $button;
            })
            ->addColumn('status_id', function ($data) {
                $button = ($data->status) ? $data->status->status : '-';
                return $button;
            })
            ->addColumn('golongan_id', function ($data) {
                $button = ($data->golongan) ? $data->golongan->golongan : '-';
                return $button;
            })
            ->addColumn('action', function ($data) {
                $buttons = "";
                if ($data->status->code == '08' || $data->status->code == '09' ||  $data->status->code == '03') {
                    if (auth()->user()->can('claim.detail')) {
                        $buttons .= makeButton([
                            'type' => 'url',
                            'url'   => $this->route . '/' . $data->id . '',
                            'class'   => 'btn btn-icon btn-info btn-sm btn-hover-light',
                            'label'   => '<i class="flaticon2-list-1"></i>',
                            'tooltip' => 'Detail'
                        ]);
                    }
                } else {

                    if (auth()->user()->can('claim.forward')) {
                        if ($data->status->code == '02' || $data->status->code == '03') {
                            $buttons .= makeButton([
                                'type' => 'modal',
                                'url'   => $this->route . '/' . $data->id . '/edit',
                                'class'   => 'btn btn-icon btn-warning btn-sm btn-hover-light custome-modal',
                                'label'   => '<i class="flaticon2-paperplane"></i>',
                                'tooltip' => 'Teruskan'
                            ]);
                        }
                    }

                    if (auth()->user()->can('claim.stage')) {
                        if ($data->status->code == '04' || $data->status->code == '05' || $data->status->code == '06' || $data->status->code == '07') {
                            $buttons .= makeButton([
                                'type' => 'modal',
                                'url'   => $this->route . '/' . $data->id . '/edit-stage',
                                'class'   => 'btn btn-icon btn-success btn-sm btn-hover-light custome-modal',
                                'label'   => '<i class="flaticon2-checking"></i>',
                                'tooltip' => 'Tahapan'
                            ]);
                        }
                    }

                    if (auth()->user()->can('claim.detail')) {
                        $buttons .= makeButton([
                            'type' => 'url',
                            'url'   => $this->route . '/' . $data->id . '',
                            'class'   => 'btn btn-icon btn-info btn-sm btn-hover-light',
                            'label'   => '<i class="flaticon2-list-1"></i>',
                            'tooltip' => 'Detail'
                        ]);
                    }
                }

                return $buttons;
            })
            ->rawColumns(['numSelect', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Data Klaim',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
        ];

        return view('backend.laporan.claim.create', $data);
    }

    public function store(ClaimPelangganRequest $request)
    {
        if (request()->sosial_media == '' && request()->no_telepon == '') {
            $this->validate($request, [
                'sosial_media' => 'required',
                'no_telepon' => 'required',
            ]);
        }
        $tglPelaporan = Carbon::parse($request->tanggal_pelaporan)->format('Y-m-d');
        $recordData =  ClaimPelanggan::where(DB::raw('UPPER(nama_pelanggan)'), 'like', '%' . strtoupper($request->nama_pelanggan) . '%')
            ->where('no_telepon', $request->no_telepon)
            ->whereDate('tanggal_pelaporan', $tglPelaporan)
            ->where('jenis_claim_id', $request->jenis_claim_id)
            ->where('ruas_id', $request->ruas_id)->first();

        if ($recordData) {
            $noTiket = ($recordData) ? $recordData->no_tiket : '-';
            $idData = ($recordData) ? $recordData->id : '-';
            return response([
                'messageBox' => "Klaim sedang di proses dengan no tiket <a href='" . url('claim/' . $idData) . "'>" . $noTiket . "</a>",
            ], 412);
        }

        DB::beginTransaction();
        try {
            // $dataRuas = MasterRuas::find($request->ruas_id);

            // if ($dataRuas) {
            //   $dataRo = $dataRuas->ro;
            //   if ($dataRo) {
            //     $dataRegional = $dataRo->regional;
            //     if ($dataRegional) {
            //       $request['regional_id'] = $dataRegional->id;
            //     }
            //   }
            // }

            $request['user_id'] = auth()->user()->id;
            $request['status_id'] = MasterStatus::where('code', '01')->where('type', 2)->first()->id;

            $record = ClaimPelanggan::saveData($request);
            $record->no_tiket = getTiketClaim($record);
            $record->save();
            // $record->keluhanUnit()->create([
            //   'unit_id' => $record->unit_id,
            //   'created_by' => $request->user_id
            // ]);

            $this->firebase->notify($record);

            $record->history()->create([
                // 'ruas_id' => $record->ruas_id,
                // 'regional_id' => $record->regional_id,
                'unit_id' => $record->unit_id,
                'status_id' => MasterStatus::where('code', '01')->where('type', 2)->first()->id
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

    public function history(Request $request, $id)
    {
        $record = ClaimPelanggan::findOrFail($id);

        if (!isset($request->unit_id)) {
            $penyelesaian = $request->penyelesaian;
            unset($request['penyelesaian']);
            $request['status_id'] = MasterStatus::where('code', '04')->where('type', 2)->first()->id;
            $record->history()->create($request->all());
            $request['status_id'] = MasterStatus::where('code', '05')->where('type', 2)->first()->id;
            $record->history()->create($request->all());
            $record->status_id = $request->status_id;
            $record->penyelesaian = $penyelesaian;
            $record->save();
        } else {
            $request['status_id'] = MasterStatus::where('code', '04')->where('type', 2)->first()->id;
            $record->status_id = $request->status_id;
            $record->penyelesaian = $request->penyelesaian;
            $record->save();
            unset($request['ruas_id']);
            unset($request['penyelesaian']);
            $record->history()->create($request->all());
        }

        $this->firebase->notify($record);

        return response([
            'status' => true,
            'message' => 'success',
        ]);
    }

    public function editStage($id)
    {

        $data = [
            'route' => $this->route,
            'record' => ClaimPelanggan::findOrFail($id)
        ];

        return view('backend.laporan.claim.edit-stage', $data);
    }

    public function historyStage(Request $request, $id)
    {
        if (!request()->status == '06') {
            $this->validate($request, [
                'negosiasi_dan_klarifikasi' => 'required'
            ]);
        } elseif (request()->status == '07') {
            $this->validate($request, [
                'proses_pembayaran' => 'required'
            ]);
        } elseif (request()->status == '08') {
            $this->validate($request, [
                'pembayaran_selesai' => 'required',
                'nominal_final' => 'required'
            ]);
        }
        $record = ClaimPelanggan::findOrFail($id);

        $request['status_id'] = MasterStatus::where('code', $request->status)->where('type', 2)->first()->id;
        $request['unit_id'] = $record->unit_id;

        if ($request->nominal_final) {
            $record->nominal_final = $request->nominal_final;
        }

        $record->status_id = $request->status_id;
        $record->save();

        unset($request['status']);
        unset($request['negosiasi_dan_klarifikasi']);
        unset($request['proses_pembayaran']);
        unset($request['pembayaran_selesai']);
        unset($request['nominal_final']);
        $record->history()->create($request->all());

        $this->firebase->notify($record);

        return response([
            'status' => true,
            'message' => 'success',
        ]);
    }

    public function show($id)
    {

        $record = ClaimPelanggan::findOrFail($id);

        $data = [
            'title' => 'Detail Data Klaim',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
            'record' => $record
        ];

        return view('backend.laporan.claim.show', $data);
    }

    public function claimDetail(Request $request, $id)
    {
        if (request()->keterangan_reject == '' && request()->status == 03) {
            $this->validate($request, [
                'keterangan_reject' => 'required',
            ]);
        }

        $status = MasterStatus::where('code', request()->status)->where('type', 2)->first();

        $record = ClaimPelanggan::findOrFail($id);

        $record->status_id = $status->id;

        if (request()->keterangan_reject) {
            $record->keterangan_reject = request()->keterangan_reject;
        }

        $record->save();

        $this->firebase->notify($record);

        $data['status_id'] = $status->id;
        $data['unit_id'] = $record->unit_id;

        $record->history()->create($data);

        return response([
            'status' => true,
            'message' => 'success',
        ]);
    }

    public function claimReject($id)
    {
        $record = ClaimPelanggan::findOrFail($id);

        $data = [
            'title' => 'Reject Klaim',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
            'record' => $record
        ];

        return view('backend.laporan.claim.reject', $data);
    }

    public function showAttachment($id)
    {
        $record = ClaimPelanggan::findOrFail($id);

        $data = [
            'title' => 'Detail Lampiran',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
            'record' => $record
        ];

        return view('backend.laporan.claim.show-attachment', $data);
    }
}
