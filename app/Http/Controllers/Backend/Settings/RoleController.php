<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

class RoleController extends Controller
{
  public $breadcrumbs = [
    ['name' => "Manage Role"], 
    ['link' => "#", 'name' => "Settings"],
    ['link' => "setting/role", 'name' => "Role"]
  ];

  public function __construct(){
    $this->route = 'role';
  }

  public function index(Request $request)
  {
    $data = [
      'title' => 'Role',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route,
    ];

    return view('backend.settings.role.index', $data);
  }

  public function list(Request $request)
  {

    $data  = Role::query();
    
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
    ->addColumn('active', function ($data) use ($request) {
      $button = getActive($data->active);
      return $button;
    })
    ->addColumn('action', function($data){
      $buttons = "";
      $buttons .= makeButton([
        'type' => 'modal',
        'url'   => 'setting/'.$this->route.'/'.$data->id.'/edit'
      ]);
      $buttons .= makeButton([
        'type' => 'url',
        'url'   => route($this->route.'.permission',$data->id),
        'class' => 'btn btn-icon btn-success btn-sm btn-hover-light',
        'tooltip' => 'Setting Permission'
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
    
    return view('backend.settings.role.create', $data);
  }

  public function store(){
    request()->validate(['name' => 'unique:roles,name']);
    $record = Role::saveData(request());

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }
  
  public function edit($id)
  {

    $data = [
      'route' => $this->route,
      'record' => Role::findOrFail($id)
    ];

    return view('backend.settings.role.edit', $data);
  }

  public function show($id)
  {
    
    $data =[
      'route' => $this->route,
      'record' => Role::findOrFail($id)
    ];

    return view('backend.settings.role.show', $data);
  }

  public function update($id){
    request()->validate(['name' => 'unique:roles,name,'.$id]);
    $record = Role::saveData(request());

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  public function destroy($id)
  {
    $record = Role::destroy($id);

    return response([
      'status' => true,
      'message' => 'success',
    ]);

  }

  public function removeMulti(){
    $record = Role::whereIn('id',request()->id)->delete();

    return response([
      'status' => true,
      'message' => 'success',
    ]);
  }

  // other
  public function permission($id){
    $record = Role::findOrFail($id);

    $data =[
      'title' => 'Setting Permission Role '.$record->name,
      'route' => $this->route,
      'record' => $record
    ];

    return view('backend.settings.role.edit-permission', $data);
  }

  public function storePermission(){
    $role = Role::findById(request()->id);
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
        $record = Role::findById($role->id);
        $record->permissions()->sync($permsi);
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
      }   
    }else{
      $permsi = Permission::whereIn('name', [])->get()->pluck('id');
      $record = Role::findById($role->id);
      $record->permissions()->sync($permsi);
      app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    return response([
      'status' => true,
      'message' => 'success'
    ]);
  }
}
