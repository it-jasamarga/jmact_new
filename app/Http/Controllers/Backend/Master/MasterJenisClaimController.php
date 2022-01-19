<?php

namespace App\Http\Controllers\Backend\Master;

use App\Http\Controllers\Controller;
use App\Filters\MasterJenisClaimFilter;
use App\Http\Requests\MasterJenisClaimRequest;
use App\Models\MasterJenisClaim;
use Illuminate\Http\Request;

class MasterJenisClaimController extends Controller
{
    public $breadcrumbs = [
        ['name' => "Master Jenis Claim"], 
        ['link' => "#", 'name' => "Master"],
        ['link' => "master-claim", 'name' => "Master Claim"]
    ];
    
    public function __construct() {
        $this->route = 'master-claim';
    }
    
    public function index(Request $request) {
      $data = [
        'title' => 'Jenis Claim',
        'breadcrumbs' => $this->breadcrumbs,
        'route' => $this->route,
      ];

      return view('backend.master.master-claim.index', $data);
    }

    public function list(MasterJenisClaimFilter $request) {

        $data  = MasterJenisClaim::query()->filter($request);

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
        if(auth()->user()->can('master-claim.edit')) {
          $buttons .= makeButton([
              'type' => 'modal',
              'url'   => $this->route.'/'.$data->id.'/edit'
          ]);
        }
        // $buttons .= makeButton([
        //   'type' => 'delete',
        //   'id'   => $data->id
        // ]);
        return $buttons;
        })
        // ->rawColumns(['numSelect','action'])
        ->addIndexColumn()
        ->make(true);

    }

    public function create() {
        $data = [
        'route' => $this->route
        ];
        
        return view('backend.master.master-claim.create', $data);
    }

    public function store(MasterJenisClaimRequest $request) {
        $record = MasterJenisClaim::saveData($request);
    
        return response([
          'status' => true,
          'message' => 'success',
        ]);
    }
      
    public function edit($id) {
    
        $data = [
          'route' => $this->route,
          'record' => MasterJenisClaim::findOrFail($id)
        ];
    
        return view('backend.master.master-claim.edit', $data);
    }
    
    public function show($id) {
        
        $data =[
          'route' => $this->route,
          'record' => MasterJenisClaim::findOrFail($id)
        ];
    
        return view('backend.master.master-claim.show', $data);
    }

    public function update(MasterJenisClaimRequest $request, $id){
        $record = MasterJenisClaim::saveData($request);
    
        return response([
          'status' => true,
          'message' => 'success',
        ]);
    }
    
    public function destroy($id) {
        $record = MasterJenisClaim::destroy($id);
    
        return response([
          'status' => true,
          'message' => 'success',
        ]);
    
    }
    
    public function removeMulti() {
        $record = MasterJenisClaim::whereIn('id',request()->id)->delete();
    
        return response([
          'status' => true,
          'message' => 'success',
        ]);
    }
}
