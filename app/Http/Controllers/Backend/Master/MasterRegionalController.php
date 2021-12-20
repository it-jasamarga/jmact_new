<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Models\MasterRegional;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

use App\Filters\MasterRegionalFilter;
use App\Http\Requests\MasterRegionalRequest;


class MasterRegionalController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Master Regional"], 
    ['link' => "#", 'name' => "Master"],
    ['link' => "master-regional", 'name' => "Master Regional"]
  ];

  public function __construct(){
    $this->route = 'master-regional';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Master Regional',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.master.master-regional.index', $data);
  }

  public function list(MasterRegionalFilter $request)
  {

    $data  = MasterRegional::query()->filter($request);

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
      $buttons .= makeButton([
        'type' => 'delete',
        'id'   => $data->id
      ]);
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
    
    return view('backend.master.master-regional.create', $data);
  }

  public function store(MasterRegionalRequest $request){
    $record = MasterRegional::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => MasterRegional::findOrFail($id)
    ];

    return view('backend.master.master-regional.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => MasterRegional::findOrFail($id)
    ];

    return view('backend.master.master-regional.show', $data);
  }

  public function update(MasterRegionalRequest $request, $id){
    $record = MasterRegional::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = MasterRegional::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = MasterRegional::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
