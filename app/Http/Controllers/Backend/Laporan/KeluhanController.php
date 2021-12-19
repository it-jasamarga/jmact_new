<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KeluhanPelanggan;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

use App\Filters\KeluhanPelangganFilter;
use App\Http\Requests\KeluhanPelangganRequest;


class KeluhanPelangganController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Master Bidang Keluhan"], 
    ['link' => "#", 'name' => "Master"],
    ['link' => "master-bk", 'name' => "Master Bidang Keluhan"]
  ];

  public function __construct(){
    $this->route = 'master-bk';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Filter Data Master Bidang Keluhan',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.master.master-bk.index', $data);
  }

  public function list(KeluhanPelangganFilter $request)
  {

    $data  = KeluhanPelanggan::query()->filter($request);

    return datatables()->of($data)
    ->addColumn('numSelect', function ($data) use ($request) {
      $button = '';
      $button .= makeButton([
        'type' => 'deleteAll',
        'value' => $data->id
      ]);
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
    
    return view('backend.master.master-bk.create', $data);
  }

  public function store(KeluhanPelangganRequest $request){
    $record = KeluhanPelanggan::saveData($request);

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => KeluhanPelanggan::findOrFail($id)
    ];

    return view('backend.master.master-bk.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => KeluhanPelanggan::findOrFail($id)
    ];

    return view('backend.master.master-bk.show', $data);
  }

  public function update(KeluhanPelangganRequest $request, $id){
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

  public function removeMulti(){
    $record = KeluhanPelanggan::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
