<?php

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\MasterRo;
use DB;

class OptionController extends Controller
{
    
    public function ro($id)
    {
        return MasterRo::options('name','id',['filters' => ['regional_id' => $id]],'( Pilih Data )');
    }
    
}
