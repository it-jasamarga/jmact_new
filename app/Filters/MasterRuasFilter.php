<?php
namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MasterRuasFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function name($term) {
        return $this->builder->where('name', "LIKE","%$term%");
    }

    public function regional_id($term) {
        return $this->builder->whereHas('ro', function($q) use($term){
            $q->whereHas('regional',function($q1) use($term){
                $q1->where('id',$term);
            });
        });
    }

    public function regional_name($term) {
        return $this->builder->whereHas('ro', function($q) use($term){
            $q->whereHas('regional',function($q1) use($term){
                $q1->where('name', "LIKE","%$term%");
            });
        });
    }

    public function ro_id($term) {
        return $this->builder->where('ro_id', $term);
    }

    public function ro_name($term) {
        return $this->builder->whereHas('ro', function($q) use($term){
            $q->where('name', "LIKE","%$term%");
        });
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
