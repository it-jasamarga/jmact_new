<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterStatus;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

use App\Filters\MasterStatusFilter;
use App\Http\Requests\MasterStatusRequest;


class MasterStatusController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Master Data Status"], 
    ['link' => "#", 'name' => "Master"],
    ['link' => "master-status", 'name' => "Master Status"]
  ];

  public function __construct(){
    $this->route = 'master-status';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Master Status',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.master.master-status.index', $data);
  }

  public function list(MasterStatusFilter $request)
  {

    $data  = MasterStatus::query()->filter($request);

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
    ->addColumn('action', function($data){
      $buttons = "";
      $buttons .= makeButton([
        'type' => 'modal',
        'url'   => $this->route.'/'.$data->id.'/edit'
      ]);
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
    
    return view('backend.master.master-status.create', $data);
  }

  public function store(MasterStatusRequest $request){
    $record = MasterStatus::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => MasterStatus::findOrFail($id)
    ];

    return view('backend.master.master-status.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => MasterStatus::findOrFail($id)
    ];

    return view('backend.master.master-status.show', $data);
  }

  public function update(MasterStatusRequest $request, $id){
    $record = MasterStatus::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = MasterStatus::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = MasterStatus::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
