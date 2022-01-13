<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterBk;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

use App\Filters\MasterBkFilter;
use App\Http\Requests\MasterBkRequest;


class MasterBkController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Master Data Bidang Keluhan"], 
    ['link' => "#", 'name' => "Master"],
    ['link' => "master-bk", 'name' => "Master Bidang Keluhan"]
  ];

  public function __construct(){
    $this->route = 'master-bk';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Bidang Keluhan',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.master.master-bk.index', $data);
  }

  public function list(MasterBkFilter $request)
  {

    $data  = MasterBk::query()->filter($request);

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
    
    return view('backend.master.master-bk.create', $data);
  }

  public function store(MasterBkRequest $request){
    $record = MasterBk::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => MasterBk::findOrFail($id)
    ];

    return view('backend.master.master-bk.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => MasterBk::findOrFail($id)
    ];

    return view('backend.master.master-bk.show', $data);
  }

  public function update(MasterBkRequest $request, $id){
    $record = MasterBk::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = MasterBk::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = MasterBk::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
