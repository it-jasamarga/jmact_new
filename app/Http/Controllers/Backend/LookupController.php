<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\KeluhanPelanggan;
use App\Filters\KeluhanPelangganFilter;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LookupController extends Controller
{

    public function list(KeluhanPelangganFilter $request)
    {
  
        $data  = KeluhanPelanggan::with('history')
            ->whereHas('history',function($q) { $q->where('unit_id',auth()->user()->unit_id); })
            ->select('*')
            ->filter($request);
  
        if(auth()->user()->hasRole('Superadmin')){
            $data  = KeluhanPelanggan::orderByDesc('created_at')->select('*')->filter($request);
        }

        if(auth()->user()->hasRole('JMTC')){
            $data  = KeluhanPelanggan::where('status_id','1')
                ->orderByDesc('created_at')->select('*')->filter($request);
        }

        if(auth()->user()->hasRole('Service Provider')){
            $data  = KeluhanPelanggan::with('history')
                ->where('unit_id',auth()->user()->unit_id)
                ->orderByDesc('created_at')
                ->select('*')
                ->filter($request);
        }

        if(auth()->user()->hasRole('Regional')){
            $regionalId = (auth()->user()) ? auth()->user()->regional_id : null;
            $data  = KeluhanPelanggan::where('regional_id',$regionalId)
                ->orderByDesc('created_at')
                ->select('*')
                ->filter($request);
        }
  
        return datatables()->of($data)
            ->addColumn('sumber_id', function ($data) use ($request) {
                return ($data->sumber) ? $data->sumber->description : '-';
            })
            ->addColumn('bidang_id', function ($data) use ($request) {
                return ($data->bidang) ? $data->bidang->bidang : '-';
            })
            ->addColumn('golongan_id', function ($data) use ($request) {
                return ($data->golongan) ? $data->golongan->golongan : '-';
            })
            ->addColumn('status_id', function ($data) use ($request) {
                return ($data->status) ? $data->status->status : '-';
            })
            ->addIndexColumn()
            ->make(true);
    }
  

    public function dataChart(Request $request, $name) {
        $params = $request->all();
        $return = ['status' => 'error', 'name' => $name, 'type' => "bar"];

        // $month = $params['filters']['month'];
        // $year = $params['filters']['year'];

        if ($name == 'summary') {

            $query = DB::table('detail_history')
                ->select(
                    'master_regional.name AS regional_name', 'keluhan.no_tiket',
                    DB::raw('MAX(keluhan.status_id) AS status_id'),
                    DB::raw('MIN(CASE WHEN master_status.status = "On Progress" AND master_status.type=1 THEN detail_history.created_at ELSE CAST("9999-12-31 23:59:59" AS DATETIME) END) AS StartSLA'),
                    DB::raw('MAX(CASE WHEN master_status.status = "Closed" AND master_status.type=1 THEN detail_history.created_at ELSE CAST("1990-01-01 00:00:00" AS DATETIME) END) AS EndSLA')
                )
                ->leftJoin('master_regional', 'master_regional.id', '=', 'detail_history.regional_id')
                ->leftJoin('keluhan', 'keluhan.id', '=', 'detail_history.keluhan_id')
                ->leftJoin('master_status', 'master_status.id', '=', 'detail_history.status_id')
                ->where('master_status.type', 1)
                ->where('master_status.status', '=', 'On Progress')
                ->Orwhere('master_status.status', '=', 'Closed')
                ->groupBy('master_regional.name', 'keluhan.no_tiket', 'master_status.status', 'master_status.type')
                ->orderBy('keluhan.no_tiket')
                ->get();

            $return['data'] = [];

            $return['data']['regional'] = \App\Models\MasterRegional::where('active', 1)->get(['id', 'name'])->pluck('name', 'id');
            $return['status'] = \App\Models\MasterStatus::where('active', 1)->where('type', 1)->get(['id', 'status'])->pluck('status', 'id');
            $data = [];
            foreach ($query as $record) {
                $data[$record->regional_name][$record->no_tiket]['status'] = $return['status'][$record->status_id];
                (substr($record->StartSLA, 0, 4) != '9999') && ($data[$record->regional_name][$record->no_tiket]['start'] = $record->StartSLA);
                (substr($record->EndSLA, 0, 4) != '1990') && ($data[$record->regional_name][$record->no_tiket]['end'] = $record->EndSLA);
            }
            foreach ($data as $regional_name => $regional_data) {
                foreach ($regional_data as $no_tiket => $SLA) {
                    $startSLA = Carbon::createFromDate($SLA['start']);
                    if (isset($SLA['start'])) {
                        $data[$regional_name][$no_tiket]['days'] = (($data[$regional_name][$no_tiket]['status'] == 'Closed') && (isset($SLA['end']))) ?
                            $startSLA->diffInDays(Carbon::createFromDate($SLA['end'])) : $startSLA->diffInDays(Carbon::now());
                    }
                }
                $collection = collect($data[$regional_name]);
                $return['data']['statistic'][$regional_name]['ontime'] = $collection->where('status', 'Closed')->where('days', '<=', 3)->count();
                $return['data']['statistic'][$regional_name]['onprogress'] = $collection->where('status', '<>', 'Closed')->where('days', '<=', 3)->count();
                $return['data']['statistic'][$regional_name]['overtime'] = $collection->where('status', '<>', 'Closed')->where('days', '>', 3)->count();
            }

            $return['data']['records'] = $data;
            $return['status'] = "ok";
        } else {

            $return['filters'] = $params['filters'];
            $date_start = $params['filters']['date_start'];
            $date_end = $params['filters']['date_end'];
            
            if ($name == 'area') {
                switch ($params['filters']['category']) {
                    case 'regional':
                        $query = \App\Models\MasterRo::where('active', 1)->where('regional_id', $params['filters']['category_id'])->get(['name']);
                        foreach ($query as $record) {
                            $return['data'][$name][$record->name] = rand(0, 100);
                        }
                        $return['status'] = 'ok';
                        break;
                    case 'ro':
                        $query = \App\Models\MasterRuas::where('active', 1)->where('ro_id', $params['filters']['category_id'])->get(['name']);
                        foreach ($query as $record) {
                            $return['data'][$name][$record->name] = rand(0, 100);
                        }
                        $return['status'] = 'ok';
                        break;
                    case 'ruas':
                        $query = \App\Models\MasterRuas::where('active', 1)->where('id', $params['filters']['category_id'])->get(['name']);
                        foreach ($query as $record) {
                            $return['data'][$name][$record->name] = rand(0, 100);
                        }
                        $return['status'] = 'ok';
                        break;
                }
            } else if ($name == 'source') {

                $query = \App\Models\MasterSumber::where('active', 1)->get(['description']);
                foreach ($query as $record) {
                    $return['data'][$name][$record->description] = rand(0, 100);
                }
                $return['status'] = 'ok';

            } else if ($name == 'sector') {

                $return['type'] = "pie";
                $query = \App\Models\MasterBk::where('active', 1)->get(['bidang']);
                foreach ($query as $record) {
                    $return['data'][$name][$record->bidang] = rand(0, 100);
                }
                $return['status'] = 'ok';

            }
        }
        
        return response()->json($return);
    }

    public function area(Request $request, $category) {
        $return = ['status' => 'error'];

        switch ($category) {
            // case 'status-pengerjaan-regional':
            //     $return['data'] = [
            //         'Nusantara' => [
            //             'Overtime'      => ['#993333', 10],
            //             'OnProgress'    => ['#333399', 11],
            //             'OnTime'        => ['#339933', 12],
            //             'BehindTime'    => ['#660000', 13],
            //         ]
            //     ];
            //     $return['status'] = 'ok';
            //     break;
            case 'regional':
                $return['data'] = \App\Models\MasterRegional::where('active', 1)
                    ->get(['id', 'name'])
                    ->pluck('name', 'id')
                    ->toArray()
                    ;
                $return['status'] = 'ok';
                break;
            case 'ro':
                $return['data'] = [];
                $query = \App\Models\MasterRo::where('active', 1)
                    ->with('regional')
                    ->get(['id', 'name', 'regional_id'])
                    ;
                foreach ($query as $record) {
                    $return['data'][$record->id] = $record->regional->name .' - '. $record->name;
                }
                $return['status'] = 'ok';
                break;
            case 'ruas':
                $return['data'] = [];
                $query = \App\Models\MasterRuas::where('active', 1)
                    ->with('ro')
                    ->get(['id', 'name', 'ro_id'])
                    ;
                // $return['data'] = $query->toArray();
                foreach ($query as $record) {
                    $return['data'][$record->id] = $record->ro->regional->name .' - '. $record->ro->name .' - '. $record->name;
                }
                $return['status'] = 'ok';
                break;
        }

        return response()->json($return);
    }
}
