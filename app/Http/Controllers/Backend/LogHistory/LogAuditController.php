<?php

namespace App\Http\Controllers\Backend\LogHistory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;
use DB;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;

class LogAuditController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Log Audit"], 
    ['link' => "#", 'name' => "Log History"],
    ['link' => "setting/log-audit", 'name' => "Log Audit Reportings"]
  ];

  public function __construct(){
    $this->route = 'log-audit';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Filter Data Log Audit',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.history.audit.index', $data);
  }

  public function list(Request $request)
  {

    $data  = Audit::with('user','auditable')->orderBy('id', 'DESC')->get();
    
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
    ->addColumn('created_at', function($data)
    {
        return createdAt($data->created_at);
    })
    ->addColumn('user', function($data){
        if(isset($data->user->name)){
            return "<p>". $data->user->name ."<br>". $data->user->email . "<p>";
        }else{
            return "-";
        }
    })
    ->addColumn('record', function($data){
        if(isset($data->auditable)){
            $route = explode('\\', $data->auditable_type);
            $route = end($route);
            $route = strtolower($route);
            return $data->auditable_id;
        }else{
            return $data->auditable_id;
        }
    })
    ->addColumn('event', function($data)
    {
        return eventType($data->event);
    })
    ->addColumn('action', function($data){
      $buttons = "";
      $buttons .= makeButton([
        'type' => 'modal',
        'tooltip' => 'Detail Data',
        'url'   => $this->route.'/'.$data->id.'/edit'
      ]);
      
      return $buttons;
    })
    ->rawColumns(['numSelect','action','created_at','user','record','event'])
    ->addIndexColumn()
    ->make(true);

  }

  
  public function create()
  {
    $data = [
      'route' => $this->route
    ];
    
    return view('backend.history.audit.create', $data);
  }

  public function store(){
    request()->validate(['name' => 'unique:roles,name']);
    $record = Audit::saveData(request());

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $record = Audit::with('user','auditable')->find($id);
    $old_values     = $record->old_values;
    $new_values     = $record->new_values;
    // debug($old_values, $new_values);
    $data = [
      'route' => $this->route,
      'record' => $record,
      'old_values' => $old_values,
      'new_values' => $new_values,
    ];

    return view('backend.history.audit.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => Audit::find($id)
    ];

    return view('backend.history.audit.show', $data);
  }

  public function update($id){
    request()->validate(['name' => 'unique:roles,name,'.$id]);
    $record = Audit::saveData(request());

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = Audit::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = Audit::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
