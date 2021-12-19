<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterRuas;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

use App\Filters\MasterRuasFilter;
use App\Http\Requests\MasterRuasRequest;


class MasterRuasController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Master Ruas"], 
    ['link' => "#", 'name' => "Master"],
    ['link' => "master-ruas", 'name' => "Master Ruas"]
  ];

  public function __construct(){
    $this->route = 'master-ruas';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Filter Data Master Ruas',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.master.master-ruas.index', $data);
  }

  public function list(MasterRuasFilter $request)
  {

    $data  = MasterRuas::query()->filter($request);

    return datatables()->of($data)
    ->addColumn('numSelect', function ($data) use ($request) {
      $button = '';
      $button .= makeButton([
        'type' => 'deleteAll',
        'value' => $data->id
      ]);
      return $button;
    })
    ->addColumn('ro_id', function ($data) use ($request) {
      $button = ($data->ro) ? $data->ro->name : '-';
      return $button;
    })
    ->addColumn('regional_id', function ($data) use ($request) {
      $button = ($data->ro->regional) ? $data->ro->regional->name : '-';
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
      $buttons .= makeButton([
        'type' => 'delete',
        'id'   => $data->id
      ]);
      return $buttons;
    })
    ->rawColumns(['numSelect','regional_id','action'])
    ->addIndexColumn()
    ->make(true);

  }

  
  public function create()
  {
    $data = [
      'route' => $this->route
    ];
    
    return view('backend.master.master-ruas.create', $data);
  }

  public function store(MasterRuasRequest $request){
    $record = MasterRuas::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => MasterRuas::findOrFail($id)
    ];

    return view('backend.master.master-ruas.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => MasterRuas::findOrFail($id)
    ];

    return view('backend.master.master-ruas.show', $data);
  }

  public function update(MasterRuasRequest $request, $id){
    $record = MasterRuas::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = MasterRuas::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = MasterRuas::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
