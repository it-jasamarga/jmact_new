@extends('layouts/app')

@section('styles')
@endsection

@section('content')
<div class="card card-custom" data-card="true" id="kt_card_4">
 <div class="card-header">
  <div class="card-title">
    <h3 class="card-label">{{ $title }}
      <span class="text-muted pt-2 font-size-sm d-block">pengelolahan data </span></h3>
    </div>
    <div class="card-toolbar">
     <a href="#" class="btn btn-icon btn-sm btn-light-primary mr-1" data-card-tool="toggle">
       <i class="ki ki-arrow-down icon-nm"></i>
     </a>
   </div>
 </div>
 <div class="card-body">
  <form action="{{ route($route.'.storePermission') }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('POST')
    @csrf

    <input type="hidden" name="id" value="{{ $record->id }}">
    <input type="hidden" name="name" value="{{ $record->name }}">
    <div class="panel panel-default">
      @include('backend.settings.role.partial.edit')
    </div>
    <div class="panel-footer float-right">
      <a href="{{ url()->previous() }}" class="btn btn-sm btn-default btn-addon">
        <i class="flaticon-reply"></i> Back
      </a>
      <button type="button" class="btn btn-sm btn-light-success font-weight-bold btn-addon pull-right save button">
        <i class="flaticon-cogwheel"></i> Save
      </button>
    </div>

  </form>
</div>
</div>
<br>

@endsection

@section('scripts')
<script type="text/javascript">
  $(document).on('click', '.verticall.all', function(e){
    e.preventDefault();
    var container   = $(this).closest('thead');
    var action    = $(this).data('action');
    var selector  = $('.'+action+'.check');
    var checked   = true;
    container.next('tbody').find(selector).each(function(e){
      checked = !$(this).prop('checked') ? false : checked;
    });

    container.next('tbody').find(selector).prop('checked', !checked);
  });

  $(document).on('click', '.verticall-custom.all', function(e){
    e.preventDefault();
    var classs    = $(this).data('class');
    var checked   = true;
    $('.'+classs).each(function(e){
      checked = !$(this).prop('checked') ? false : checked;
    });

    $('.'+classs).prop('checked', !checked);
  });

  $(document).on('click', '.horizontal.all', function(e){
    e.preventDefault();
    var container   = $(this).closest('tr');
    var selector  = $('.check');
    var checked   = true;

    container.find(selector).each(function(e){
      checked = !$(this).prop('checked') ? false : checked;
      // $(this).prop('checked', !$(this).prop('checked'));
    });

    container.find(selector).prop('checked', !checked);
  });
</script>
@endsection
