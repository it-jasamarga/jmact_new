<?php
namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClaimPelangganFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function no_tiket($term) {
        return $this->builder->where('no_tiket', "LIKE","%$term%");
    }

    public function nama_pelanggan($term) {
        return $this->builder->where('nama_pelanggan', "LIKE","%$term%");
    }

    public function tanggal_awal($term) {
        $tanggal_awal = Carbon::parse($term)->format('Y-m-d');
        return $this->builder->whereDate('tanggal_kejadian','>=',$tanggal_awal);
    }

    public function tanggal_akhir($term) {
        $tanggal_akhir = Carbon::parse($term)->format('Y-m-d');
        return $this->builder->whereDate('tanggal_kejadian','<=',$tanggal_akhir);
    }

    public function ruas_id($term) {
        return $this->builder->where('ruas_id', $term);
    }

    public function golongan_id($term) {
        return $this->builder->where('golongan_id', $term);
    }

    public function status_id($term) {
        return $this->builder->where('status_id', $term);
    }

    public function jenis_claim_id($term) {
        return $this->builder->where('jenis_claim_id', $term);
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
