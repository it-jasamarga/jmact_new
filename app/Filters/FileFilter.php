<?php
namespace App\Filters;
use App\Models\File;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FileFilter extends QueryFilters
{
    protected $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function extension($term) {
        return $this->builder->where('extension', $term);
    }
    public function name($term) {
        return $this->builder->where('name', 'LIKE', "%$term%");
    }
    public function url($term) {
        return $this->builder->where('url', 'LIKE', "%$term%");
    }

    public function target_type($term) {
        return $this->builder->where('target_type', "$term");
    }

    public function target_id($term) {
        return $this->builder->where('target_id', "$term");
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

public function sort_title($type = null) {
    return $this->builder->orderBy('title', (!$type || $type == 'asc') ? 'asc' : 'desc');
}
}
