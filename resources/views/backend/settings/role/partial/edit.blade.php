
<table class="table table-striped b-t b-light table-bordered">
  <thead>
    <tr>
      <th class="text-center" width="250">
        <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Fitur</div>
      </th>
      <th class="text-center">
        <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Aksi Fitur</div>
      </th>
      <th class="text-center">
        <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Checklist</div>
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
    <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Aksi Fitur</div>
  </th>
  <th class="text-center">
    <div class="btn btn-light-primary font-weight-bold btn-addon btn-sm" ><i class="flaticon2-menu-4"></i>Checklist</div>
  </th>
  @else
    <th class="text-center">
      <div class="checkbox-inline">
        @if($perms->count() > 0)
          @foreach($perms as $k => $value)
            <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
              <input name="check[]" class="index check" type="checkbox" value="{{ $value->name }}" @if($record->hasPermissionTo($item->perms.'.index')) checked @endif>
              <span></span>{{ explode('.',$value->name)[1] }}
            </label>
          @endforeach
        @endif 
      </div>
    </th>
    <th class="text-center">
      <button class="btn btn-pesat-colour btn-addon btn-sm horizontal all"><i class="flaticon2-checkmark"></i>Check </button>
    </th>
  @endif
  </thead>

  <!-- CHILD -->

  @if(isset($item->submenu) && (count($item->submenu) > 0))
  <tbody>
    @foreach($item->submenu as $bigChild)
    <tr>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="{{ isset($bigChild->icon) ? $bigChild->icon : '' }} icon"></i> {!! $bigChild->name !!} </td>
      @php
          $perms = \App\Models\Permission::where('name', 'like', $bigChild->perms.'%')->get();
      @endphp
      <td class="text-center">
        <div class="checkbox-inline">
          @if($perms->count() > 0)
            @foreach($perms as $k => $value)
              <label class="checkbox checkbox-square checkbox-outline checkbox-outline-2x checkbox-success">
                <input name="check[]" class="index check" type="checkbox" value="{{ $value->name }}" @if($record->hasPermissionTo($bigChild->perms.'.index')) checked @endif>
                <span></span>{{ explode('.',$value->name)[1] }}
              </label>
            @endforeach
          @endif 
        </div>
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
