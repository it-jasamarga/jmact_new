<?php

namespace App\Http\Controllers\Backend\LogHistory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;
use DB;

class BugReportController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Bug"], 
    ['link' => "#", 'name' => "Log History"],
    ['link' => "setting/bug-report", 'name' => "Bug Reportings"]
  ];

  public function __construct(){
    $this->route = 'bug-report';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Filter Data Bug',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.history.bug.index', $data);
  }

  public function list(Request $request)
  {

    $data  = DB::table('bugReportings')->select('*');
    
    if($name = $request->name){
      $data = $data->where('name','like', '%' . $name . '%');
    }

    return datatables()->of($data)
    ->addColumn('numSelect', function ($data) use ($request) {
      $button = '';
      $button .= makeButton([
        'type' => 'deleteAll',
        'value' => $data->id
      ]);
      return $button;
    })
    ->addColumn('class', function ($data) use ($request) {
      $button = "<p>
      <span class='bg-light'>".$data->class."</span>
      <h4 class='text-bold'>".$data->message."</h4>
      <span class='bg-light'>".$data->url."</span>
      <br>File: ".$data->file."
      <br>Line: ". $data->line."
      </p>";
      return $button;
    })
    ->addColumn('action', function($data){
      $buttons = "";
      if(auth()->user()->can('bug-report.delete')) {
        $buttons .= makeButton([
          'type' => 'delete',
          'id'   => $data->id
        ]);
      }
      return $buttons;
    })
    ->rawColumns(['numSelect','class','action'])
    ->addIndexColumn()
    ->make(true);

  }

  
  public function create()
  {
    $data = [
      'route' => $this->route
    ];
    
    return view('backend.history.bug.create', $data);
  }

  public function store(){
    
    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => DB::table('bugReportings')->findOrFail($id)
    ];

    return view('backend.history.bug.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => DB::table('bugReportings')->find($id)
    ];

    return view('backend.history.bug.show', $data);
  }

  public function update($id){

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = DB::table('bugReportings')->destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = DB::table('bugReportings')->whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
}
