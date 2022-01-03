<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterRo;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

use App\Filters\MasterRoFilter;
use App\Http\Requests\MasterRoRequest;


class MasterRoController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Master Data Ro"], 
    ['link' => "#", 'name' => "Master"],
    ['link' => "master-ro", 'name' => "Master Ro"]
  ];

  public function __construct(){
    $this->route = 'master-ro';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Master Ro',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.master.master-ro.index', $data);
  }

  public function list(MasterRoFilter $request)
  {

    $data  = MasterRo::query()->filter($request);

    return datatables()->of($data)
    ->addColumn('numSelect', function ($data) use ($request) {
      $button = '';
      $button .= makeButton([
        'type' => 'deleteAll',
        'value' => $data->id
      ]);
      return $button;
    })
    ->addColumn('regional_id', function ($data) use ($request) {
      $button = ($data->regional) ? $data->regional->name : '-';
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
        'modal' => '#largeModal',
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
    
    return view('backend.master.master-ro.create', $data);
  }

  public function store(MasterRoRequest $request){
    $record = MasterRo::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => MasterRo::findOrFail($id)
    ];

    return view('backend.master.master-ro.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => MasterRo::findOrFail($id)
    ];

    return view('backend.master.master-ro.show', $data);
  }

  public function update(MasterRoRequest $request, $id){
    $record = MasterRo::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = MasterRo::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = MasterRo::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
