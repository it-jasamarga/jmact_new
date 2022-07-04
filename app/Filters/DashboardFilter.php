<?php
namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardFilter extends QueryFilters
{
    // public $http;
    public $request;

    public function __construct(Request $request)
    {
        // $this->http = $request;
        $this->request = $request;
        parent::__construct($request);
    }

    // public function nama_cust($term) {
    //     return $this->builder->where('nama_cust', "LIKE","%$term%");
    // }

    // public function no_tiket($term) {
    //     return $this->builder->where('no_tiket', "LIKE","%$term%");
    // }

    // public function tanggal_awal($term) {
    //     $tanggal_awal = Carbon::parse($term)->format('Y-m-d');
    //     return $this->builder->whereDate('created_at','>=',$tanggal_awal);
    // }

    // public function tanggal_akhir($term) {
    //     $tanggal_akhir = Carbon::parse($term)->format('Y-m-d');
    //     return $this->builder->whereDate('created_at','<=',$tanggal_akhir);
    // }

    // public function sumber_id($term) {
    //     return $this->builder->where('sumber_id', $term);
    // }

    // public function bidang_id($term) {
    //     return $this->builder->where('bidang_id', $term);
    // }

    public function category($value) {
        $scope = $this->request->input('dashscope')."_";
        $dashfilter = [];
        $cid = $this->request->input($scope.'category_id');
        $tanggal_awal = Carbon::parse($this->request->input($scope.'tanggal_awal'))->format('Y-m-d');
        $tanggal_akhir = Carbon::parse($this->request->input($scope.'tanggal_akhir'))->format('Y-m-d');
        $this->request['CID'] = $cid;
        switch($value) {
            case 'regional':
                $ro = \App\Models\MasterRo::where('regional_id', $cid)->get(['id'])->pluck('id');
                $dashfilter = \App\Models\MasterRuas::whereIn('ro_id', $ro)->get(['id'])->pluck('id');
                break;
            case 'ro':
                $dashfilter = \App\Models\MasterRuas::where('ro_id', $cid)->get(['id'])->pluck('id');
                break;
            case 'ruas':
                $dashfilter[] = $cid;
                break;
        }
        // $this->request['where-in:ruas_id'] = $dashfilter;
        return $this->builder
            ->whereIn('ruas_id', $dashfilter)
            ->whereDate('created_at','>=',$tanggal_awal)
            ->whereDate('created_at','<=',$tanggal_akhir);
    }

    // public function ruas_id($term) {
    //     return $this->builder->where('ruas_id', $term);
    // }

    // public function user_id($term) {
    //     return $this->builder->where('user_id', $term);
    // }

    // public function golongan_id($term) {
    //     return $this->builder->where('golongan_id', $term);
    // }

    // public function status_id($term) {
    //     return $this->builder->where('status_id', $term);
    // }

    // public function active($term) {
    //   return $this->builder->where('active', $term);
    // }

    // public function id($term) {
    //   return $this->builder->where('id', $term);
    // }

    public function sort($array) {
        $myArray = explode(',', $array);
        foreach ($myArray as $value) {
              $this->builder->orderBy($value,'desc');
        }
    }

    public function sort_date($type = null) {
        return $this->builder->orderBy('created_at', (!$type || $type == 'asc') ? 'desc' : 'desc');
    }

    public function sort_name($type = null) {
        return $this->builder->orderBy('title', (!$type || $type == 'asc') ? 'asc' : 'desc');
    }

}
