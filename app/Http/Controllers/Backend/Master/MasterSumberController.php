<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterSumber;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

use App\Filters\MasterSumberFilter;
use App\Http\Requests\MasterSumberRequest;


class MasterSumberController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Master Sumber"], 
    ['link' => "#", 'name' => "Master"],
    ['link' => "master-sumber", 'name' => "Master Sumber"]
  ];

  public function __construct(){
    $this->route = 'master-sumber';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Master Sumber',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.master.master-sumber.index', $data);
  }

  public function list(MasterSumberFilter $request)
  {

    $data  = MasterSumber::query()->filter($request);

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
    
    return view('backend.master.master-sumber.create', $data);
  }

  public function store(MasterSumberRequest $request){
    $record = MasterSumber::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => MasterSumber::findOrFail($id)
    ];

    return view('backend.master.master-sumber.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => MasterSumber::findOrFail($id)
    ];

    return view('backend.master.master-sumber.show', $data);
  }

  public function update(MasterSumberRequest $request, $id){
    $record = MasterSumber::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = MasterSumber::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = MasterSumber::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
