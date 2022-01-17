<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

class PermissionController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Permission"], 
    ['link' => "#", 'name' => "Settings"],
    ['link' => "setting/permission", 'name' => "Permission"]
  ];

  public function __construct(){
    $this->route = 'permission';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Permission',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.settings.permission.index', $data);
  }

  public function list(Request $request)
  {

    $data  = Permission::query();
    
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
    ->addColumn('action', function($data){
      $buttons = "";
      $buttons .= makeButton([
        'type' => 'modal',
        'modal' => '#mediumModal',
        'url'   => 'setting/'.$this->route.'/'.$data->id.'/edit'
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
    
    $dataMenuJson = file_get_contents(base_path('resources/json/menuJson.json'));
    $json = json_decode($dataMenuJson,true);
    $dataMenu = [];
    foreach($json['menu'] as $k => $value){
      if(is_array($value['perms'])){
        foreach($value['perms'] as $k1 => $value1){
          array_push($dataMenu, str_replace('-', ' ', $value1));
        } 
      }else{
        array_push($dataMenu, str_replace('-', ' ', $value['perms']));
      }
    }

    $data['dataMenu'] = $dataMenu;
    return view('backend.settings.permission.create', $data);
  }

  public function store(){
    request()->validate(['name' => 'required|string|regex:/(^[a-zA-Z]+[a-zA-Z0-9\\-]*$)/u|unique:permissions,name']);
    if(request()->permission){
      $dataName = request()->name;
      request()['name'] = str_replace(' ', '-', request()->permission).'.'.$dataName;
    }
    $record = Permission::saveData(request());

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $record = Permission::findOrFail($id);
    $permission = explode('.',$record->name)[0];
    $name = explode('.',$record->name)[1];
    $data = [
      'route' => $this->route,
      'record' => $record,
      'permission' => $permission,
      'name' => $name,
    ];

    $dataMenuJson = file_get_contents(base_path('resources/json/menuJson.json'));
    $json = json_decode($dataMenuJson,true);
    $dataMenu = [];
    foreach($json['menu'] as $k => $value){
      if(is_array($value['perms'])){
        foreach($value['perms'] as $k1 => $value1){
          array_push($dataMenu, str_replace('-', ' ', $value1));
        } 
      }else{
        array_push($dataMenu, str_replace('-', ' ', $value['perms']));
      }
    }

    $data['dataMenu'] = $dataMenu;

    return view('backend.settings.permission.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => Permission::findOrFail($id)
    ];

    return view('backend.settings.permission.show', $data);
  }

  public function update($id){
    request()->validate(['name' => 'required|string|regex:/(^[a-zA-Z]+[a-zA-Z0-9\\-]*$)/u|unique:permissions,name,'.$id]);
    if(request()->permission){
      $dataName = request()->name;
      request()['name'] = str_replace(' ', '-', request()->permission).'.'.$dataName;
    }
    $record = Permission::saveData(request());

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = Permission::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = Permission::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  // other
  public function permission($id){
    $record = Permission::findOrFail($id);

    $data =[
      'title' => 'Setting Permission Role '.$record->name,
      'route' => $this->route,
      'record' => $record
    ];

    return view('backend.settings.permission.edit-permission', $data);
  }

  public function storePermission(){
    $role = Permission::findById(request()->id);
    if(isset(request()->check)){
      if(count(request()->check) > 0){
        foreach (request()->check as $key => $value) {
          $temp = [
            'name' => $value,
          ];
          if(Permission::where('name', $value)->count() == 0){
            \Spatie\Permission\Models\Permission::create($temp);
          }
        }
        $permsi = Permission::whereIn('name', request()->check)->pluck('id');
        $record = Permission::findById($role->id);
        $record->permissions()->sync($permsi);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
      }   
    }else{
      $permsi = Permission::whereIn('name', [])->get()->pluck('id');
      $record = Permission::findById($role->id);
      $record->permissions()->sync($permsi);
      app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    return response([
      'status' => true,
      'message' => 'success'
    ]);
  }
}
