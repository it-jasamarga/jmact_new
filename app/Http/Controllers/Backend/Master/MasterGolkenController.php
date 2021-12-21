<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterGolken;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

use App\Filters\MasterGolkenFilter;
use App\Http\Requests\MasterGolkenRequest;


class MasterGolkenController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Master Golongan Kendaraan"], 
    ['link' => "#", 'name' => "Master"],
    ['link' => "master-golken", 'name' => "Master Golongan Kendaraan"]
  ];

  public function __construct(){
    $this->route = 'master-golken';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Master Golongan Kendaraan',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.master.master-golken.index', $data);
  }

  public function list(MasterGolkenFilter $request)
  {

    $data  = MasterGolken::query()->filter($request);

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
    ->rawColumns(['numSelect','action'])
    ->addIndexColumn()
    ->make(true);

  }

  
  public function create()
  {
    $data = [
      'route' => $this->route
    ];
    
    return view('backend.master.master-golken.create', $data);
  }

  public function store(MasterGolkenRequest $request){
    $record = MasterGolken::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => MasterGolken::findOrFail($id)
    ];

    return view('backend.master.master-golken.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => MasterGolken::findOrFail($id)
    ];

    return view('backend.master.master-golken.show', $data);
  }

  public function update(MasterGolkenRequest $request, $id){
    $record = MasterGolken::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = MasterGolken::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = MasterGolken::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
