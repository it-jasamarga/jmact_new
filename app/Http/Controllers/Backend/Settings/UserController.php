<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use JWTAuth;

class UserController extends Controller
{
  public $breadcrumbs = [
      ['name' => "Manage User"], 
      ['link' => "#", 'name' => "Settings"],
      ['link' => "setting/users", 'name' => "Users"]
  ];

  public function __construct(){
    $this->route = 'users';
  }

  public function index(Request $request)
  {
    return view('backend.settings.user.index', [
      'title' => 'Users',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route
    ]);
  }

  public function list(Request $request)
  {
    
    $data  = User::query()->orderByDesc('created_at');

    if($name = $request->name){
      $data = $data->where('name','like', '%' . $name . '%');
    } 
    if ($username = $request->username) {
      $data = $data->where('username','like', '%' . $username . '%');
    } 
    if ($unit_id = $request->unit_id) {
      $data = $data->where('unit_id', $unit_id);
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
    ->addColumn('unit_id', function ($data) use ($request) {
      $button = ($data->unit) ? $data->unit->unit : '-';
      return $button;
    })
    ->addColumn('active', function ($data) use ($request) {
      $button = getActive($data->active);
      return $button;
    })
    ->addColumn('created_at', function ($data) use ($request) {
      return $data->creationDate();
    })
    ->addColumn('action', function($data){
      $buttons = "";
      if(auth()->user()->can('user-account.edit')) {
        $buttons .= makeButton([
            'type' => 'modal',
            'url'   => 'setting/'.$this->route.'/'.$data->id.'/edit'
        ]);
      }
        // $buttons .= makeButton([
        //   'type' => 'delete',
        //   'id'   => $data->id
        // ]);
      return $buttons;
    })
    ->rawColumns(['action','numSelect'])
    ->addIndexColumn()
    ->make(true);

  }

    /**
     * Show the form for creating a new resource.asdasdsa
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('backend.settings.user.create',[
        'route' => $this->route
      ]);
    }

    /**
     * Store a newly created resource in storage. sadsadasasdasd
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $record = User::findOrFail($id);
      return view('backend.settings.user.edit',[
        'route' => $this->route,
        'record' => $record,
      ]);
    }

    public function show($id)
    {
      $record= User::findOrFail($id);
      return view('backend.settings.user.show',[
        'route' => $this->route,
        'record' => $record,
      ]);
    }

    public function destroy($id)
    {
      $record = User::destroy($id);
      return response([
        'status' => true,
        'message' => 'success',
      ]);
    }

    public function store()
    {
      // dd(request()->all());
      request()->validate([
        'email' => 'unique:users,email',
        'password' => 'required|string|min:6|max:250|confirmed'
      ]);
      $role = request()->role;
      unset(request()['role']);
      unset(request()['password_confirmation']);
      $passwords = request()->password;
      
      if(request()->password){
        request()['password'] = bcrypt($passwords);
      }

      $record = User::saveData(request());
      if($role){
        \DB::table('role_users')->where('user_id',$record->id)->delete();
        $createHasRole = \DB::table('role_users')->insert([
          'role_id' => $role,
          'user_id' => $record->id,
        ]);
      }
      return response([
        'status' => true,
        'message' => 'success',
      ]);
    }

    public function update($id)
    {
      request()->validate(['email' => 'unique:users,email,'.$id]);
      $role = request()->role;
      unset(request()['role']);
      unset(request()['password_confirmation']);
      
      $record = User::find(request()->id);

      $passwords = request()->password;
      if(request()->password){
        request()['password'] = bcrypt($passwords);
      }else{
        request()['password'] = $record->password;
      }
      
      $record = User::saveData(request());

      if($role){
        \DB::table('role_users')->where('user_id',$record->id)->delete();
        $createHasRole = \DB::table('role_users')->insert([
          'role_id' => $role,
          'user_id' => $record->id,
        ]);
      }
      return response([
        'status' => true,
        'message' => 'success',
      ]);
    }

    public function device(){
      $record = User::findOrFail(auth()->user()->id);
      $record->device_id = request()->device_id;
      $record->save();

      $messaging = app('firebase.messaging');
      $topic = (auth()->user()->unit) ? auth()->user()->unit->unit : 'public';
      if(request()->device_id){
        $registrationTokens = [
          request()->device_id
        ];
        $messaging->subscribeToTopic("".$topic."", $registrationTokens);
      }

      return response([
        'status' => true,
        'message' => 'success',
      ]);
    }
  }
