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
        ['link' => "user-account", 'name' => "Users"]
    ];

    public function __construct()
    {
        $this->route = 'user-account';
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
        if ($name = $request->name) {
            $data = $data->where('name', 'like', '%' . $name . '%');
        }
        if ($username = $request->username) {
            $data = $data->where('username', 'like', '%' . $username . '%');
        }
        if ($unit_id = $request->unit_id) {
            $data = $data->where('unit_id', $unit_id);
        }
        // if ($role_id = $request->role_id) {
        //   $data = $data->where('role_id', $role_id);
        // }

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
            ->addColumn('role_id', function ($data) use ($request) {
                $button = ($data->roles->first()) ? $data->roles->first()->name : '-';
                return $button;
            })
            ->addColumn('active', function ($data) use ($request) {
                $button = getActive($data->active);
                return $button;
            })
            ->addColumn('created_at', function ($data) use ($request) {
                return $data->creationDate();
            })
            ->addColumn('action', function ($data) {
                $buttons = "";
                if (auth()->user()->can('user-account.edit')) {
                    $buttons .= makeButton([
                        'type' => 'modal',
                        // 'url'   => 'setting/' . $this->route . '/' . $data->id . '/edit',
                        'url'   => $this->route . '/' . $data->id . '/edit',
                        'tooltip' => 'Edit',
                    ]);
                }
                // $buttons .= makeButton([
                //   'type' => 'delete',
                //   'id'   => $data->id
                // ]);
                return $buttons;
            })
            ->rawColumns(['action', 'numSelect'])
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
        return view('backend.settings.user.create', [
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
        return view('backend.settings.user.edit', [
            'route' => $this->route,
            'record' => $record,
        ]);
    }

    public function show($id)
    {
        $record = User::findOrFail($id);
        return view('backend.settings.user.show', [
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
        $custom_message = [];

        $validate = [
            'name' => 'required|string|min:3|max:250',
            'username' => 'required|string|min:3|max:250',
            'unit_id' => 'required',
            'role' => 'required',
            'active' => 'required'
        ];

        if (request()->is_ldap === '1') {
            $validate['username'] = 'required|string|min:3|max:80|unique:users,npp';
            $custom_message = ['username.required' => 'The npp field is required.'];
            request()['npp'] = request()['username'];
        } else {
            $validate['username'] = 'required|string|min:3|max:80|unique:users,username';
            $validate['password'] = 'required|string|min:6|max:250|confirmed';
            request()['npp'] = null;
            request()['is_ldap'] = 0;
        }

        request()->validate($validate, $custom_message);

        $role = request()->role;
        unset(request()['role']);
        unset(request()['password_confirmation']);
        $passwords = request()->password;

        if (request()->password) {
            request()['password'] = bcrypt($passwords);
        }

        $record = User::saveData(request());
        if ($role) {
            \DB::table('role_users')->where('user_id', $record->id)->delete();
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
        $custom_message = [];

        $validate = [
            'name' => 'required|string|min:3|max:250',
            'username' => 'required|string|min:3|max:250',
            'unit_id' => 'required',
            'role' => 'required',
            'active' => 'required'
        ];

        $record = User::find(request()->id);

        if (request()->is_ldap === '1') {
            if (request()->npp != request()->username) {
                $validate['username'] = 'required|string|min:3|max:80|unique:users,username';
            }
            $validate['username'] = 'required|string|min:3|max:80|unique:users,npp';
            $custom_message = ['username.required' => 'The npp field is required.'];
            request()['npp'] = request()['username'];
        } else {
            if (request()->username != request()->username) {
                $validate['username'] = 'required|string|min:3|max:80|unique:users,username';
            }
            if ((request()->password == '') && (!is_null($record->password))) {
                unset(request()['password']);
            } else {
                $validate['password'] = 'required|string|min:6|max:250|confirmed';
            }
            request()['npp'] = null;
            request()['is_ldap'] = 0;
        }

        request()->validate($validate, $custom_message);

        // request()->validate(['email' => 'unique:users,email,'.$id]);
        $role = request()->role;
        unset(request()['role']);
        unset(request()['password_confirmation']);

        $passwords = request()->password;
        if (request()->password) {
            request()['password'] = bcrypt($passwords);
        } else {
            request()['password'] = $record->password;
        }

        $record = User::saveData(request());

        if ($role) {
            \DB::table('role_users')->where('user_id', $record->id)->delete();
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

    public function device()
    {
        return response([
            'status' => false,
            'message' => 'error',
            'description' => "Deprecated by ADR, incorporated in login controller"
        ]);

        /*
        if (! request()->device_id) return response([
            'status' => false,
            'message' => 'error'
        ]);

        if (! \App\Models\UserDevice::where('user_id', auth()->user()->id)->where('token', request()->device_id)->exists()) {
            \App\Models\UserDevice::create([
                'user_id'   => auth()->user()->id,
                'token'     => request()->device_id,
                'misc'      => request()->header('user-agent')
            ]);
        }

        $record = User::findOrFail(auth()->user()->id);
        $record->device_id = request()->device_id;
        $record->save();

        $topic = null;
        $messaging = app('firebase.messaging');
        if (auth()->user()->unit) {
            $topic = auth()->user()->unit->unit;
            $messaging->subscribeToTopic($topic, [ request()->device_id ]);
        }

        return response([
            'status' => true,
            'message' => 'success',
            'FBM-subscribed-topic' => $topic
        ]);
        */
    }
}
