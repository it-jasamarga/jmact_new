<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\MasterRo;
use App\Models\MasterRuas;
use DB;

class OptionController extends Controller
{
    
    public function ro($id)
    {
        return MasterRo::options('name','id',['filters' => ['regional_id' => $id]],'( Pilih Data )');
    }

    public function ruas($id)
    {
        $record = MasterRo::where('regional_id',$id)->pluck('id')->toArray();
        $result = MasterRuas::options('name','id', ['filters' => [function($q) use($record){
            $q->whereIn('ro_id',$record);
        }]]);
        return $result;
    }
    
}
