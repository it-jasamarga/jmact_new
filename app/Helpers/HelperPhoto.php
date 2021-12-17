<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use Config;
use Illuminate\Support\Str;

use App\Models\File;
use Image;
use Carbon\Carbon;
use Hash;

class HelperPhoto{

	public static function checkMime($mime = ''){
	    $return = false;
	    if($mime == "image/png"){
	      $return = true;
	    }elseif($mime == "image/jpg"){
	      $return = true;
	    }elseif($mime == "image/jpeg"){
	      $return = true;
	    }elseif($mime == "image/gif"){
	      $return = true;
	    }elseif($mime == "gif"){
	      $return = true;
	    }elseif($mime == "jpeg"){
	      $return = true;
	    }elseif($mime == "jpg"){
	      $return = true;
	    }elseif($mime == "png"){
	      $return = true;
	    }elseif($mime == "tiff"){
	      $return = true;
	    }else{
	      $return = false;
	    }

	    return $return;
	}

	public static function upload($file = null, $targetType = null, $targetId = null, $requestName = null, $requestType = null, $id = null){
		if(($file != null) && (is_file($file))){
          
          $name = str_replace(' ', '_', $file->getClientOriginalName());
          $name = str_replace('/', '', $name);
          $name = md5($name.''.Carbon::now()->format('Ymdhis')).'.'.$file->getClientOriginalExtension();
          $data['filename'] = $name;
          $data['url'] = $file->storeAs($targetType, $name, 'public');
          $data['target_type'] = $targetType;
          $data['target_id'] = $targetId;
          $data['request_name'] = $requestName;
          $data['request_type'] = $requestType;

          $save = new File;
      	  if($id){
      	  	$save = File::find($id);
      	  	if(!$save){
          		$save = new File;
      	  	}
      	  }
          $save->fill($data);
          $save->save();

          $mime = HelperPhoto::checkMime($file->getClientOriginalExtension());
          if($mime == true){
          	  $img = Image::make(asset('storage/'.$save->url));
	          $img->resize(400, null, function ($constraint) {
	              $constraint->aspectRatio();
	          });
	          $nameCek = md5($save->filename.''.Carbon::now()->format('Ymdhis')).'.'.$file->getClientOriginalExtension();
	          $nameCek = str_replace('/', '', $nameCek);
	          $nameCek = str_replace(' ', '_', $nameCek);
	          $saveName = public_path('storage/'.$targetType.'/'.$nameCek);
	          $img->save($saveName);
	          $url = $targetType.'/'.$nameCek;


	          $data['filename'] = $saveName;
	          $data['url'] = $url;
	          $data['type'] = 'Meta';
	          $data['target_type'] = $targetType;
	          $data['target_id'] = $targetId;
	          $data['request_name'] = $requestName;
          	  $data['request_type'] = $requestType;

	          $saveNew = new File;
          	  if($id){
          	  	$saveNew = File::find($id);
          	  	if(!$saveNew){
	          		$saveNew = new File;
          	  	}
          	  }
	          $saveNew->fill($data);
	          $saveNew->save();   

          }
        }
	}
}
