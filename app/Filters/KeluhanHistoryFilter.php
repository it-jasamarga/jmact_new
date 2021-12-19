<?php
namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KeluhanHistoryFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function ruas_id($term) {
        return $this->builder->where('ruas_id', $term);
    }

    public function keluhan_id($term) {
        return $this->builder->where('keluhan_id', $term);
    }

    public function provider($term) {
        return $this->builder->where('provider', $term);
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
