<?php

namespace App\Http\Controllers\Backend\LogHistory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;
use DB;
use OwenIt\Auditing\Models\Audit;
use Carbon\Carbon;
use Yadahan\AuthenticationLog\AuthenticationLog;

class LogAuthController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Log Auth"], 
    ['link' => "#", 'name' => "Log History"],
    ['link' => "setting/log-auth", 'name' => "Log Auth Reportings"]
  ];

  public function __construct(){
    $this->route = 'log-auth';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Filter Data Log Auth',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.history.auth.index', $data);
  }

  public function list(Request $request)
  {

    $data  = AuthenticationLog::with('authenticatable')->get();
    
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
    ->addColumn('login_at', function($data)
    {
        return createdAt($data->login_at);
    })
    ->addColumn('user', function($data){
        if($data->authenticatable){
            return "<p>". $data->authenticatable->name ."<br>". $data->authenticatable->email . "<p>";
        }else{
            return "-";
        }
    })
    
    ->rawColumns(['numSelect','user','login_at'])
    ->addIndexColumn()
    ->make(true);

  }

  
  public function create()
  {
    $data = [
      'route' => $this->route
    ];
    
    return view('backend.history.auth.create', $data);
  }

  public function store(){
    request()->validate(['name' => 'unique:roles,name']);
    $record = AuthenticationLog::saveData(request());

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

    return view('backend.history.auth.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => DB::table('bugReportings')->find($id)
    ];

    return view('backend.history.auth.show', $data);
  }

  public function update($id){
    request()->validate(['name' => 'unique:roles,name,'.$id]);
    $record = AuthenticationLog::saveData(request());

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = AuthenticationLog::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = AuthenticationLog::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

}
