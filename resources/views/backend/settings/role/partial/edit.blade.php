
<table class="table table-striped b-t b-light table-bordered">
  <thead>
    <tr>
      <th class="text-center" width="250">
        <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Features</div>
      </th>
      <th class="text-center">
        <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Index</div>
      </th>
      <th class="text-center">
        <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Create</div>
      </th>
      <th class="text-center">
        <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Edit</div>
      </th>
      <th class="text-center">
        <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Show</div>
      </th>
      <th class="text-center">
        <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Delete</div>
      </th>
      <th class="text-center">
        <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Action</div>
      </th>

    </tr>
  </thead>

  @foreach($menuData[0]->menu as $item)
  @php
  if(!@$item->section){
  if(is_array($item->perms)){
  $perms = \App\Models\Permission::where(function($query) use ($item) {
  for($i = 0; $i < count($item->perms); $i++)
  {
    $query->orWhere('name', 'like', $item->perms[$i].'%');
  }
})->get();
}else{
$perms = \App\Models\Permission::where('name', 'like', $item->perms.'%')->get();
}
}
@endphp

@if(@$item->section)
<thead>
  <th> <strong>SECTION {!! $item->section !!}</strong></th>
</thead>

@else

<thead>
  <th><i class="{{ $item->icon }} icon"></i> {!! $item->name !!}</th>
  @if(isset($item->submenu) && (count($item->submenu) > 0))
  <th class="text-center">
    <button class="btn btn-pesat-colour btn-addon btn-sm verticall all" data-action="index"><i class="flaticon2-checkmark"></i>Check </button>
  </th>
  <th class="text-center">
    <button class="btn btn-pesat-colour btn-addon btn-sm verticall all" data-action="create"><i class="flaticon2-checkmark"></i>Check </button>
  </th>
  <th class="text-center">
    <button class="btn btn-pesat-colour btn-addon btn-sm verticall all" data-action="edit"><i class="flaticon2-checkmark"></i>Check </button>
  </th>
  <th class="text-center">
    <button class="btn btn-pesat-colour btn-addon btn-sm verticall all" data-action="show"><i class="flaticon2-checkmark"></i>Check </button>
  </th>
  <th class="text-center">
    <button class="btn btn-pesat-colour btn-addon btn-sm verticall all" data-action="delete"><i class="flaticon2-checkmark"></i>Check </button>
  </th>
  <th class="text-center">
   <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Action</div>
 </th>
 @else
 <th class="text-center">
  @if (in_array('index',$item->action))
  @if($p = $perms->where('name', $item->perms.'.list')->first())
  <div class="checkbox-inline" style="display: none">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="index check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($item->perms.'.list')) checked @endif>
      <span></span>Pilih
    </label>
  </div>
  @else
  <div class="checkbox-inline" style="display: none">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="index check" type="checkbox" value="{{ $item->perms.'.list' }}">
      <span></span>Pilih
    </label>
  </div>
  @endif
  @if($p = $perms->where('name', $item->perms.'.index')->first())
  <div class="checkbox-inline">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="index check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($item->perms.'.index')) checked @endif>
      <span></span>Pilih
    </label>
  </div>
  @else
  <div class="checkbox-inline">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="index check" type="checkbox" value="{{ $item->perms.'.index' }}">
      <span></span>Pilih
    </label>
  </div>
  @endif
  @endif
</th>
<th class="text-center">
  @if (in_array('create',$item->action))
  @if($p = $perms->where('name', $item->perms.'.create')->first())
  <div class="checkbox-inline">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="create check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($item->perms.'.create')) checked @endif>
      <span></span>Pilih
    </label>
  </div>
  @else
  <div class="checkbox-inline">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="create check" type="checkbox" value="{{ $item->perms.'.create' }}">
      <span></span>Pilih
    </label>
  </div>
  @endif
  @endif
</th>
<th class="text-center">
  @if (in_array('edit',$item->action))
  @if($p = $perms->where('name', $item->perms.'.edit')->first())
  <div class="checkbox-inline">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="edit check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($item->perms.'.edit')) checked @endif>
      <span></span>Pilih
    </label>
  </div>
  @else
  <div class="checkbox-inline">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="edit check" type="checkbox" value="{{ $item->perms.'.edit' }}">
      <span></span>Pilih
    </label>
  </div>
  @endif
  @endif
</th>
<th class="text-center">
  @if (in_array('show',$item->action))
  @if($p = $perms->where('name', $item->perms.'.show')->first())
  <div class="checkbox-inline">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="show check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($item->perms.'.show')) checked @endif>
      <span></span>Pilih
    </label>
  </div>
  @else
  <div class="checkbox-inline">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="show check" type="checkbox" value="{{ $item->perms.'.show' }}">
      <span></span>Pilih
    </label>
  </div>
  @endif
  @endif
</th>
<th class="text-center">
  @if(in_array('delete',$item->action))
  @if($p = $perms->where('name',$item->perms.'.delete')->first())
  <div class="checkbox-inline">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="delete check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($item->perms.'.delete')) checked @endif>
      <span></span>Pilih
    </label>
  </div>
  @else
  <div class="checkbox-inline">
    <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
      <input name="check[]" class="delete check" type="checkbox" value="{{ $item->perms.'.delete' }}">
      <span></span>Pilih
    </label>
  </div>
  @endif
  @endif
</th>
<th class="text-center">
  <button class="btn btn-pesat-colour btn-addon btn-sm horizontal all"><i class="flaticon2-checkmark"></i>Check </button>
</th>
@endif
</thead>

@if(isset($item->submenu) && (count($item->submenu) > 0))
<tbody>
  @foreach($item->submenu as $bigChild)
  <tr>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="{{ isset($bigChild->icon) ? $bigChild->icon : '' }} icon"></i> {!! $bigChild->name !!} </td>

    <td class="text-center">

      @if(in_array('index',$bigChild->action))
      @if($perms->count() > 0)
      @if($p = $perms->where('name', $bigChild->perms.'.list')->first())
      <div class="checkbox-inline" style="display: none">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="index check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($bigChild->perms.'.list')) checked @endif>
          <span></span>Pilih
        </label>
      </div>
      @else
      <div class="checkbox-inline" style="display: none">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="index check" type="checkbox" value="{{ $bigChild->perms.'.list' }}">
          <span></span>Pilih
        </label>
      </div>
      @endif
      @endif
      @if($p = $perms->where('name', $bigChild->perms.'.index')->first())
      <div class="checkbox-inline">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="index check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($bigChild->perms.'.index')) checked @endif>
          <span></span>Pilih
        </label>
      </div>
      @else
      <div class="checkbox-inline">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="index check" type="checkbox" value="{{ $bigChild->perms.'.index' }}">
          <span></span>Pilih
        </label>
      </div>
      @endif
      @endif
    </td>
    <td class="text-center">
      @if (in_array('create',$bigChild->action))
      @if($p = $perms->where('name', $bigChild->perms.'.create')->first())
      <div class="checkbox-inline">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="create check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($bigChild->perms.'.create')) checked @endif>
          <span></span>Pilih
        </label>
      </div>
      @else
      <div class="checkbox-inline">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="create check" type="checkbox" value="{{ $bigChild->perms.'.create' }}">
          <span></span>Pilih
        </label>
      </div>
      @endif
      @endif
    </td>
    <td class="text-center">
      @if (in_array('edit',$bigChild->action))
      @if($p = $perms->where('name', $bigChild->perms.'.edit')->first())
      <div class="checkbox-inline">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="edit check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($bigChild->perms.'.edit')) checked @endif>
          <span></span>Pilih
        </label>
      </div>
      @else
      <div class="checkbox-inline">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="edit check" type="checkbox" value="{{ $bigChild->perms.'.edit' }}">
          <span></span>Pilih
        </label>
      </div>
      @endif
      @endif
    </td>
    <td class="text-center">
      @if (in_array('show',$bigChild->action))
      @if($p = $perms->where('name', $bigChild->perms.'.show')->first())
      <div class="checkbox-inline">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="show check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($bigChild->perms.'.show')) checked @endif>
          <span></span>Pilih
        </label>
      </div>
      @else
      <div class="checkbox-inline">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="show check" type="checkbox" value="{{ $bigChild->perms.'.show' }}">
          <span></span>Pilih
        </label>
      </div>
      @endif
      @endif
    </td>
    <td class="text-center">
      @if(in_array('delete',$bigChild->action))
      @if($p = $perms->where('name', $bigChild->perms.'.delete')->first())
      <div class="checkbox-inline">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="delete check" type="checkbox" value="{{ $p->name }}" @if($record->hasPermissionTo($bigChild->perms.'.delete')) checked @endif>
          <span></span>Pilih
        </label>
      </div>
      @else
      <div class="checkbox-inline">
        <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
          <input name="check[]" class="delete check" type="checkbox" value="{{ $bigChild->perms.'.delete' }}">
          <span></span>Pilih
        </label>
      </div>
      @endif
      @endif
    </td>
    <td class="text-center">
      <button class="btn btn-pesat-add btn-addon btn-sm horizontal all"><i class="flaticon2-checkmark"></i>Check </button>
    </td>
  </tr>
  @endforeach
</tbody>
@endif  
@endif
@endforeach
</table>
