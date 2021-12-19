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
      'title' => 'List Users',
      'breadcrumbs' => $this->breadcrumbs,
      'route' => $this->route
    ]);
  }

  public function list(Request $request)
  {
    
    $data  = User::query();
    
    return datatables()->of($data)
    ->addColumn('numSelect', function ($data) use ($request) {
      $button = '';
      $button .= makeButton([
        'type' => 'deleteAll',
        'value' => $data->id
      ]);
      return $button;
    })
    ->addColumn('created_at', function ($data) use ($request) {
      return $data->creationDate();
    })
    ->addColumn('action', function($data){
      $buttons = "";
        $buttons .= makeButton([
            'type' => 'modal',
            'url'   => 'setting/'.$this->route.'/'.$data->id.'/edit'
        ]);
        $buttons .= makeButton([
          'type' => 'delete',
          'id'   => $data->id
        ]);
      return $buttons;
    })
    ->rawColumns(['action','numSelect'])
    ->addIndexColumn()
    ->make(true);

  }

    /**
     * Show the form for creating a new resource.
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
     * Store a newly created resource in storage.
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
      request()->validate(['email' => 'unique:users,email']);
      $record = User::saveData(request());
      if(request()->role){
        \DB::table('role_users')->where('user_id',$record->id)->delete();
        $createHasRole = \DB::table('role_users')->insert([
          'role_id' => request()->role,
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
      $record = User::saveData(request());
      if(request()->role){
        \DB::table('role_users')->where('user_id',$record->id)->delete();
        $createHasRole = \DB::table('role_users')->insert([
          'role_id' => request()->role,
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
        // dd($topic);
        $messaging->subscribeToTopic("".$topic."", $registrationTokens);
      }

      return response([
        'status' => true,
        'message' => 'success',
      ]);
    }
  }
