
<div class="card card-custom mb-5">
 <div class="card-header card-header-right ribbon ribbon-clip ribbon-left">
  <div class="ribbon-target" style="top: 12px;">
    <span class="ribbon-inner bg-success"></span>{{ $title }}
  </div>
</div>
<div class="card-body">
<div class="appendData" style="max-height: 350px;overflow-y: initial;">
    <div class="row totalData" data-no="0">
      <div class="col-md-10">
        <div class="form-group">
          <label>{{ __('Judul') }}</label>
          <input type="text" class="form-control" name="" required placeholder="Judul" value="*Siaga Mantap Betul" readonly="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="btn btn-icon btn-warning mr-1 mb-1 waves-effect waves-light addData" style="margin-top:20px"><i class="feather icon-plus "></i>
        </div>
        <!-- <div class="btn btn-icon btn-danger mr-1 mb-1 waves-effect waves-light" style="margin-top:20px"><i class="feather icon-delete deleteData" ></i></div> -->
      </div>

    </div>
    @if($records)
    @if($records->count() > 0)
    @foreach($records as $k => $value)
    <div class="row totalData" data-no="{{$k+1}}" id="data{{$k+1}}">
     <div class="col-md-10">
      <div class="form-group">
        <label>{{ __('Judul') }}</label>
        <input type="text" class="form-control" name="{{ $attribute }}[{{ $k+1 }}]" required placeholder="Judul" value="{{$value->title}}" placeholder="{{ $attribute }}{{ $k+1 }}">
      </div>
    </div>
    <div class="col-md-2">
      <div class="btn btn-icon btn-warning waves-effect waves-light addData" style="margin-top:20px"><i class="feather icon-plus "></i>
      </div>
      <div class="btn btn-icon btn-danger waves-effect waves-light deleteData" style="margin-top:20px" data-length="data{{$k+1}}"><i class="feather icon-delete" ></i>
      </div>
    </div>
  </div>
  @endforeach
  @endif
  @endif

</div>  
</div>
</div>

@section('scripts')
<script type="text/javascript">
 $(document).on('click','.addData',function(){
  var no = $('.totalData:last').data('no')+1;
  console.log('no',no)
  $('.appendData').append(`
    <div class="row totalData" data-no="`+no+`" id="data`+no+`">
    <div class="col-md-10">
    <div class="form-group">
    <label>{{ __('Judul') }}</label>
    <input type="text" class="form-control" name="{{ $attribute }}[`+no+`]" required placeholder="Judul" >
    </div>
    </div>
    <div class="col-md-2">
    <div class="btn btn-icon btn-warning waves-effect waves-light addData" style="margin-top:20px"><i class="feather icon-plus "></i></div>
    <div class="btn btn-icon btn-danger waves-effect waves-light deleteData" style="margin-top:20px" data-length="data`+no+`"><i class="feather icon-delete" ></i></div>
    </div>
    </div>
    `);
});

 $(document).on('click','.deleteData',function(){
  var dataDel = $(this).data('length');
  $('#'+dataDel).remove();
});

</script>
@endpush
