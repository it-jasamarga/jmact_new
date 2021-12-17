<?php
namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Filters\QueryFilters;

class UserFilter extends QueryFilters
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

    public function email($term) {
        return $this->builder->where('email', $term);
    }

    public function family_identity_number($term) {
      return $this->builder->where('family_identity_number', $term);
    }

    public function id($term) {
      return $this->builder->where('id', $term);
    }

    public function region($term) {
         $this->builder->whereHas('profile',function($q) use($term){
           return $q->where('region',$term);
         });
    }

    public function gender($term) {
         $this->builder->whereHas('profile',function($q) use($term){
           return $q->where('gender',$term);
         });
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
