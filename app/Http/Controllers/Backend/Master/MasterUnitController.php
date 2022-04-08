<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterUnit;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

use App\Filters\MasterUnitFilter;
use App\Http\Requests\MasterUnitRequest;


class MasterUnitController extends Controller
{
    // private $route = 'master-unit';

    public $breadcrumbs = [
        ['name' => "Master Data Unit"],
        ['link' => "#", 'name' => "Master"],
        ['link' => "master-unit", 'name' => "Master Unit"]
    ];

    public function __construct()
    {
        $this->route = 'master-unit';
    }

    public function index(Request $request)
    {
        $data = [
            'title' => 'Unit',
            'breadcrumbs' => $this->breadcrumbs,
            'route' => $this->route,
        ];

        return view('backend.master.master-unit.index', $data);
    }

    public function list(MasterUnitFilter $request)
    {

        $data  = MasterUnit::query()->orderByDesc('created_at')->filter($request);

        return datatables()->of($data)
            ->addColumn('numSelect', function ($data) use ($request) {
                $button = '';
                $button .= makeButton([
                    'type' => 'deleteAll',
                    'value' => $data->id
                ]);
                return $button;
            })
            ->addColumn('active', function ($data) use ($request) {
                $button = getActive($data->active);
                return $button;
            })
            ->addColumn('action', function ($data) {
                $buttons = "";
                if (auth()->user()->can('master-unit.edit')) {
                    $buttons .= makeButton([
                        'type' => 'modal',
                        'url'   => $this->route . '/' . $data->id . '/edit',
                        'tooltip' => 'Edit',
                    ]);
                }
                // $buttons .= makeButton([
                //   'type' => 'delete',
                //   'id'   => $data->id
                // ]);
                return $buttons;
            })
            // ->rawColumns(['numSelect','action'])
            ->addIndexColumn()
            ->make(true);
    }


    public function create()
    {
        $data = [
            'route' => $this->route
        ];

        return view('backend.master.master-unit.create', $data);
    }

    public function store(MasterUnitRequest $request)
    {
        $record = MasterUnit::saveData($request);

        return response([
            'status' => true,
            'message' => 'success',
        ]);
    }

    public function edit($id)
    {

        $data = [
            'route' => $this->route,
            'record' => MasterUnit::findOrFail($id)
        ];

        return view('backend.master.master-unit.edit', $data);
    }

    public function show($id)
    {

        $data = [
            'route' => $this->route,
            'record' => MasterUnit::findOrFail($id)
        ];

        return view('backend.master.master-unit.show', $data);
    }

    public function update(MasterUnitRequest $request, $id)
    {
        $record = MasterUnit::saveData($request);

        return response([
            'status' => true,
            'message' => 'success',
        ]);
    }

    public function destroy($id)
    {
        $record = MasterUnit::destroy($id);

        return response([
            'status' => true,
            'message' => 'success',
        ]);
    }

    public function removeMulti()
    {
        $record = MasterUnit::whereIn('id', request()->id)->delete();

        return response([
            'status' => true,
            'message' => 'success',
        ]);
    }
}
