<?php
namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KeluhanPelangganFilter extends QueryFilters
{
    public $http;

    protected $request;
    public function __construct(Request $request)
    {
        $this->http = $request;
        $this->request = $request;
        parent::__construct($request);
    }

    public function no_tiket($term) {
        return $this->builder->where('no_tiket', "LIKE","%$term%");
    }

    public function nama_cust($term) {
        return $this->builder->where('nama_cust', "LIKE","%$term%");
    }

    public function lokasi_kejadian($term) {
        return $this->builder->where('lokasi_kejadian', "LIKE","%$term%");
    }

    public function tanggal_awal($term) {
        $tanggal_awal = Carbon::parse($term)->format('Y-m-d');
        return $this->builder->whereDate('tanggal_pelaporan','>=',$tanggal_awal);
    }

    public function tanggal_akhir($term) {
        $tanggal_akhir = Carbon::parse($term)->format('Y-m-d');
        return $this->builder->whereDate('tanggal_pelaporan','<=',$tanggal_akhir);
    }

    public function sumber_id($term) {
        return $this->builder->where('sumber_id', $term);
    }

    public function bidang_id($term) {
        return $this->builder->where('bidang_id', $term);
    }

    public function category($term) {
        $dashfilter = [];
        switch($term) {
            case 'regional':
                $ro = \App\Models\MasterRo::where('regional_id', $this->http->input('category_id'))->get(['id'])->pluck('id');
                $dashfilter = \App\Models\MasterRuas::whereIn('ro_id', $ro)->get(['id'])->pluck('id');
                break;
            case 'ro':
                $dashfilter = \App\Models\MasterRuas::where('ro_id', $this->http->input('category_id'))->get(['id'])->pluck('id');
                break;
            case 'ruas':
                $dashfilter[] = $this->http->input('category_id');
                break;
        }
        return $this->builder->whereIn('ruas_id', $dashfilter);
    }

    public function ruas_id($term) {
        return $this->builder->where('ruas_id', $term);
    }

    public function user_id($term) {
        return $this->builder->where('user_id', $term);
    }

    public function golongan_id($term) {
        return $this->builder->where('golongan_id', $term);
    }

    public function status_id($term) {
        return $this->builder->where('status_id', $term);
    }

    public function active($term) {
      return $this->builder->where('active', $term);
    }

    public function id($term) {
      return $this->builder->where('id', $term);
    }

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
