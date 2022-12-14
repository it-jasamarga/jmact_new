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
use App\Http\Requests\DetailHistoryRequest;
use App\Http\Requests\DetailReportRequest;

use App\Helpers\HelperFirestore;
use App\Models\DetailReport;
use App\Models\MasterRuas;
use DB;
use Carbon\Carbon;

class KeluhanController extends Controller
{
    // private $route = 'keluhan';

    public $breadcrumbs = [
        ['name' => "Laporan Keluhan Pelanggan"],
        ['link' => "#", 'name' => "Laporan Pelanggan"],
        ['link' => "keluhan", 'name' => "Keluhan"]
    ];

    public function __construct()
    {
        $this->route = 'keluhan';
        $this->firebase = new HelperFirestore();
        // $this->middleware(function ($request, $next) {
        //     $keluhan = (auth()->user()->hasPermissionTo('keluhan.create') || auth()->user()->hasPermissionTo('keluhan.detail') || auth()->user()->hasPermissionTo('keluhan.forward') || auth()->user()->hasPermissionTo('keluhan.sla'));
        //     try {
        //         if (!auth()->user()->hasPermissionTo($request->route()->getName())) abort(403);
        //     } catch (\Spatie\Permission\Exceptions\PermissionDoesNotExist $e) {
        //         if (!$keluhan) abort(403);
        //     }
        //     return $next($request);
        // });
    }

    public function index(Request $request)
    {
        $data = [
            'title' => 'Keluhan',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
        ];

        return view('backend.laporan.keluhan.index', $data);
    }

    public function list(KeluhanPelangganFilter $request)
    {

        $data  = KeluhanPelanggan::with('history')
            ->whereHas('history', function ($q) {
                $q->where('unit_id', auth()->user()->unit_id);
            })->orderByDesc('created_at')
            ->select('*')
            ->filter($request);

        if (auth()->user()->hasRole('Superadmin')) {
            $data  = KeluhanPelanggan::orderByDesc('created_at')->select('*')->filter($request);
        }

        if (auth()->user()->hasRole('JMTC')) {
            $data  = KeluhanPelanggan::whereHas('status', function ($q1) {
                $q1->whereIn('code', ['01', '02'])
                    ->where('type', 1);
            })
                ->orderByDesc('created_at')
                ->select('*')
                ->filter($request);
        }

        // if (auth()->user()->hasRole('Service Provider')) {
        // dd(auth()->user()->roles()->first()->type->type);
        if (auth()->user()->roles()->first()->type) {
            if (auth()->user()->roles()->first()->type->type == "Service Provider") {
                $data  = KeluhanPelanggan::with('history')
                    // ->where('unit_id', auth()->user()->unit_id)
                    ->whereHas('bidang', function ($q) {
                        $q->whereHas('unit', function ($q1) {
                            $q1->where('id', auth()->user()->unit_id);
                        });
                    })
                    ->whereHas('status', function ($q2) {
                        $q2->whereIn('code', ['02', '03', '04', '05', '06', '07'])
                            ->where('type', 1);
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
                $data  = KeluhanPelanggan::whereHas('ruas', function ($q1) use ($regionalId) {
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

        // if (@auth()->user()->roles()->first()->ro_id) {
        if (auth()->user()->roles()->first()->type) {
            if (auth()->user()->roles()->first()->type->type == "Representative Office") {
                $roId = (auth()->user()->roles()) ? auth()->user()->roles()->first()->ro_id : null;

                // $data  = KeluhanPelanggan::where('regional_id',$regionalId)
                $data  = KeluhanPelanggan::whereHas('ruas', function ($q1) use ($roId) {
                    $q1->whereHas('ro', function ($q2) use ($roId) {
                        $q2->where('id', $roId);
                    });
                })
                    ->orderByDesc('created_at')
                    ->select('*')
                    ->filter($request);
            }
        }

        return datatables()->of($data)
            ->addColumn('numSelect', function ($data) use ($request) {
                $button = '';
                $button .= makeButton([
                    'type' => 'deleteAll',
                    'value' => $data->id
                ]);
                return $button;
            })
            ->addColumn('ruas', function ($data) use ($request) {
                $button = ($data->ruas) ? $data->ruas->name : '-';
                return $button;
            })
            ->addColumn('sumber', function ($data) use ($request) {
                $button = ($data->sumber) ? $data->sumber->description : '-';
                return $button;
            })
            ->addColumn('bidang', function ($data) use ($request) {
                $button = ($data->bidang) ? $data->bidang->keluhan : '-';
                return $button;
            })
            ->addColumn('status', function ($data) use ($request) {
                $button = ($data->status) ? $data->status->status : '-';
                return $button;
            })
            ->addColumn('golongan', function ($data) use ($request) {
                $button = ($data->golongan) ? $data->golongan->golongan : '-';
                return $button;
            })
            ->addColumn('action', function ($data) use ($request) {
                $buttons = "";
                if ($data->status->code == '05' || $data->status->code == '06' || $data->status->code == '07' || $data->status->code == '08') {
                    if (auth()->user()->can('keluhan.detail')) {
                        $buttons .= makeButton([
                            'type' => 'url',
                            'url'   => $this->route . '/' . $data->id . '',
                            'class'   => 'btn btn-icon btn-info btn-sm btn-hover-light',
                            'label'   => '<i class="flaticon2-list-1"></i>',
                            'tooltip' => 'Detail'
                        ]);
                    }
                } else {
                    if (auth()->user()->can('keluhan.forward')) {
                        if ($data->status->code == '01') {
                            $buttons .= makeButton([
                                'type' => 'modal',
                                'url'   => $this->route . '/' . $data->id . '/edit',
                                'class'   => 'btn btn-icon btn-warning btn-sm btn-hover-light custome-modal',
                                'label'   => '<i class="flaticon2-paperplane"></i>',
                                'tooltip' => 'Teruskan'
                            ]);
                        }
                    }

                    if (auth()->user()->can('keluhan.sla')) {
                        $buttons .= makeButton([
                            'type' => 'url',
                            'url'   => $this->route . '/sla/' . $data->id . '',
                            'class'   => 'btn btn-icon btn-success btn-sm btn-hover-light',
                            'label'   => '<i class="flaticon-edit-1"></i>',
                            'tooltip' => 'Pengerjaan Keluhan'
                        ]);
                    }

                    if (auth()->user()->can('keluhan.detail')) {
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
            'title' => 'Add Data Keluhan',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
        ];

        return view('backend.laporan.keluhan.create', $data);
    }

    public function store(KeluhanPelangganRequest $request)
    {
        // dd(Request()->all());

        if (request()->sosial_media == '' && request()->no_telepon == '') {
            $this->validate($request, [
                'sosial_media' => 'required',
                'no_telepon' => 'required',
            ]);
        }

        $tglPeloporan = Carbon::parse($request->tanggal_pelaporan)->format('Y-m-d');
        $recordData =  KeluhanPelanggan::where(DB::raw('UPPER(nama_cust)'), 'like', '%' . strtoupper($request->nama_cust) . '%')
            ->where('no_telepon', $request->no_telepon)
            ->whereDate('tanggal_pelaporan', $tglPeloporan)
            ->where('bidang_id', $request->bidang_id)
            ->where('ruas_id', $request->ruas_id)->first();

        if ($recordData) {
            $noTiket = ($recordData) ? $recordData->no_tiket : '-';
            $idData = ($recordData) ? $recordData->id : '-';
            return response([
                'messageBox' => "Keluhan sedang di proses dengan no tiket <a href='" . url('keluhan/' . $idData) . "'>" . $noTiket . "</a>",
            ], 412);
        }

        DB::beginTransaction();
        try {
            // $dataRuas = MasterRuas::find($request->ruas_id);

            // if($dataRuas) {
            //   $dataRo = $dataRuas->ro;
            //   if ($dataRo) {
            //     $dataRegional = $dataRo->regional;
            //     if ($dataRegional) {
            //       $request['regional_id'] = $dataRegional->id;
            //     }
            //   }
            // }

            $request['user_id'] = auth()->user()->id;
            $request['status_id'] = MasterStatus::where('code', '01')->where('type', '1')->first()->id;

            $record = KeluhanPelanggan::saveData($request);
            $record->no_tiket = getTiket($record);
            $record->save();

            // $record->keluhanUnit()->create([
            //   'unit_id' => $record->unit_id,
            //   'created_by' => $request->user_id
            // ]);

            $this->firebase->notify($record);
            // $this->firebase->sendGroup(
            //     $record,
            //     'JMACT - Keluhan Kepada ' . $record->unit->unit,
            //     'Proses Keluhan Dengan No Tiket ' . $record->no_tiket
            // );

            $record->history()->create([
                // 'ruas_id' => $record->ruas_id,
                // 'regional_id' => $record->regional_id,
                'unit_id' => $record->unit_id,
                'status_id' => MasterStatus::where('code', '01')->where('type', '1')->first()->id
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

    public function history(DetailHistoryRequest $request, $id)
    {
        $record = KeluhanPelanggan::findOrFail($id);

        // $request['status_id'] = MasterStatus::where('code','03')->first()->id;
        $request['status_id'] = MasterStatus::where('code', '02')->where('type', '1')->first()->id;
        // $request['unit_id'] = $record->unit_id;
        // $request['regional_id'] = $record->regional_id;

        unset($request['ruas_id']);
        $record->status_id = $request->status_id;
        $record->unit_id = $request->unit_id;
        $record->save();
        $record->history()->create($request->all());

        $name = $record->ruas->name . ' - ' . $record->ruas->ro->name;

        $this->firebase->notify($record);
        // $this->firebase->sendGroup(
        //     $record,
        //     'JMACT - Keluhan Diteruskan Kepada Service Provider',
        //     'Diteruskan Ke ' . $name
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

        if (($record->mulaiSla->count() > 0) && ($record->report->count() >= 0)) {
            $view = 'backend.laporan.keluhan.sla.report';
        } else {
            $view = 'backend.laporan.keluhan.sla.show';
        }

        $data = [
            'title' => 'Pengerjaan Keluhan',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
            'record' => $record
        ];

        return view($view, $data);
    }

    public function prosesSla($id)
    {
        // dd(request()->all());
        // request()['status_id'] = MasterStatus::where('code','05')->first()->id;jancuk
        request()['status_id'] = MasterStatus::where('code', '03')->where('type', '1')->first()->id;

        $record = KeluhanPelanggan::findOrFail($id);

        $record->mulaiSla()->create([
            'estimate' => 3,
            'date' => Carbon::now()->addDays(3)
        ]);

        unset(request()['no_tiket']);
        unset(request()['inputer_pic']);
        unset(request()['nama_cust']);
        unset(request()['sosial_media']);
        unset(request()['no_telepon']);
        unset(request()['tanggal_pelaporan']);
        unset(request()['lokasi_kejadian']);
        unset(request()['url_file']);
        unset(request()['keterangan_keluhan']);
        // unset(request()['ruas_id']);

        $history = $record->history()->orderByDesc('created_at')->first();
        $unitHistory = ($history) ? $history->unit_id : $record->unit_id;
        $ruasHistory = ($history) ? $history->ruas_id : $record->ruas_id;
        $record->unit_id = $unitHistory;
        $record->status_id = request()->status_id;
        $record->mulai_pengerjaan = Carbon::now()->format('Y-m-d H:i:s');

        $sla = $record->bidang->sla;
        $record->deadline = Carbon::now()->addHours($sla)->format('Y-m-d H:i:s');

        $record->save();
        request()['unit_id'] = $unitHistory;
        // request()['ruas_id'] = $ruasHistory;
        // request()['regional_id'] = $record->regional_id;
        $recordHistory = $record->history()->create(request()->all());

        $this->firebase->notify($record);
        // $this->firebase->sendGroup(
        //     $record,
        //     'JMACT - Keluhan Dalam Proses SLA',
        //     'Estimasi Proses Dalam 3 Hari'
        // );
        return response([
            'status' => true,
            'message' => 'success',
            'messageBox' => 'Keluhan Dengan No Tiket ' . $record->no_tiket . ' Sedang Di Proses',
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

    public function prosesReportSla(DetailReportRequest $request, $id)
    {
        // $request['status_id'] = MasterStatus::where('code','06')->first()->id;
        $request['status_id'] = MasterStatus::where('code', '04')->where('type', '1')->first()->id;

        $record = KeluhanPelanggan::findOrFail($id);
        $record->report()->create(request()->all());

        unset($request['keterangan']);
        unset($request['url_file']);

        $history = $record->history()->orderByDesc('created_at')->first();
        $unitHistory = ($history) ? $history->unit_id : $record->unit_id;
        // $ruasHistory = ($history) ? $history->ruas_id : $record->ruas_id;
        $record->unit_id = $unitHistory;
        $record->status_id = $request['status_id'];
        $record->selesai_pengerjaan = Carbon::now()->format('Y-m-d H:i:s');
        $record->save();
        // dump($unitHistory);
        // dd($record->history()->get());

        $record->history()->create([
            'unit_id' => $unitHistory,
            // 'regional_id' => $record->regional_id,
            // 'ruas_id' => $ruasHistory,
            'status_id' => MasterStatus::where('code', '04')->where('type', '1')->first()->id
        ]);

        $this->firebase->notify($record);
        // $this->firebase->sendGroup(
        //     $record,
        //     'JMACT - Pelaporan Tiket Keluhan No Tiket' . $record->no_tiket . '',
        //     'Pelaporan Keluhan Dengan No Tiket ' . $record->no_tiket . ' Telah Selesai Dikerjakan '
        // );

        return response([
            'status' => true,
            'message' => 'success',
        ]);
    }

    public function konfirmasiPelanggan($id)
    {
        $record = KeluhanPelanggan::findOrFail($id);

        $data = [
            'title' => 'SLA',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
            'record' => $record
        ];

        return view('backend.laporan.keluhan.sla.konfirmasi-add', $data);
    }

    public function prosesKonfirmasiPelanggan($id)
    {
        // dd(request()->all());
        // if (request()->kontak_pelanggan == null || request()->konfirmasi_pelanggan == null) {
        //     $this->validate($request, [
        //         'kontak_pelanggan' => 'required',
        //         'konfirmasi_pelanggan' => 'required',
        //     ]);
        // }
        // dd(request()->all());
        // if ((request()->kontak_pelanggan == 0) || request()->konfirmasi_pelanggan == null) {
        //     return response([
        //         "message" => "The given data was invalid.",
        //         "errors" => [
        //             "kontak_pelanggan" => ["The kontak pelanggan field is required"],
        //             "konfirmasi_pelanggan" => ["The konfirmasi pelanggan field is required"]
        //         ]
        //     ], 422);
        // }

        if (!isset(request()->kontak_pelanggan) && (request()->konfirmasi_pelanggan == null)) {
            return response([
                "message" => "The given data was invalid.",
                "errors" => [
                    "kontak_pelanggan" => ["The kontak pelanggan field is required"],
                    "konfirmasi_pelanggan" => ["The konfirmasi pelanggan field is required"]
                ]
            ], 422);
        } else if (request()->konfirmasi_pelanggan == null) {
            return response([
                "message" => "The given data was invalid.",
                "errors" => [
                    "konfirmasi_pelanggan" => ["The konfirmasi pelanggan field is required"]
                ]
            ], 422);
        } else if (!isset(request()->kontak_pelanggan)) {
            return response([
                "message" => "The given data was invalid.",
                "errors" => [
                    "kontak_pelanggan" => ["The kontak pelanggan field is required"],
                ]
            ], 422);
        }

        // if (request()->kontak_pelanggan == 0 || request()->konfirmasi_pelanggan == null) {
        //     return response([
        //         "message" => "The given data was invalid.",
        //         "errors" => [
        //             "kontak_pelanggan" => ["The kontak pelanggan field is required"],
        //             "konfirmasi_pelanggan" => ["The konfirmasi pelanggan field is required"]
        //         ]
        //     ], 422);
        // } else if(request()->kontak_pelanggan == 0) {
        //     return response([
        //         "message" => "The given data was invalid.",
        //         "errors" => [
        //             "kontak_pelanggan" => ["The kontak pelanggan field is required"],
        //         ]
        //     ], 422);
        // } else {
        //     return response([
        //         "message" => "The given data was invalid.",
        //         "errors" => [
        //             "konfirmasi_pelanggan" => ["The konfirmasi pelanggan field is required"]
        //         ]
        //     ], 422);
        // }

        // $request['ya'] = (request()->kontak_pelanggan['ya']) ? 1 : 0;

        // $request['tidak'] = (request()->kontak_pelanggan['tidak']) ? 1 : 0;

        // unset($request['kontak_pelanggan']);

        $recordReport = DetailReport::where('keluhan_id', $id)->orderByDesc('created_at')->first();
        $recordReport->kontak_pelanggan = request()->kontak_pelanggan;
        $recordReport->konfirmasi_pelanggan = request()->konfirmasi_pelanggan;
        $recordReport->save();

        $request['status_id'] = MasterStatus::where('code', '05')->where('type', '1')->first()->id;

        $record = KeluhanPelanggan::findOrFail($id);
        // $record->report()->create(request()->all());

        $history = $record->history()->orderByDesc('created_at')->first();
        $unitHistory = ($history) ? $history->unit_id : $record->unit_id;
        // $ruasHistory = ($history) ? $history->ruas_id : $record->ruas_id;
        $record->unit_id = $unitHistory;
        $record->status_id = $request['status_id'];
        // $record->selesai_pengerjaan = Carbon::now()->format('Y-m-d H:i:s');
        $record->save();

        $record->history()->create([
            'unit_id' => $unitHistory,
            // 'regional_id' => $record->regional_id,
            // 'ruas_id' => $ruasHistory,
            'status_id' => MasterStatus::where('code', '05')->where('type', '1')->first()->id
        ]);

        $this->firebase->notify($record);

        return response([
            'status' => true,
            'message' => 'success',
        ]);
    }


    // END SLA

    public function show($id)
    {
        $record = KeluhanPelanggan::findOrFail($id);

        $data = [
            'title' => 'Detail Data Keluhan',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
            'record' => $record
        ];

        return view('backend.laporan.keluhan.show', $data);
    }

    public function update(KeluhanPelangganRequest $request, $id)
    {
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

    public function removeMulti()
    {
        $record = KeluhanPelanggan::whereIn('id', request()->id)->delete();

        return response([
            'status' => true,
            'message' => 'success',
        ]);
    }

    public function showAttachment($id)
    {
        $record = KeluhanPelanggan::findOrFail($id);

        $data = [
            'title' => 'Detail Lampiran',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
            'record' => $record
        ];

        return view('backend.laporan.keluhan.show-attachment', $data);
    }
}
