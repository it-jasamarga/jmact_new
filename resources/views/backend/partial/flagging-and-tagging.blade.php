
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
          <label>{{ __('Title Meta') }}</label>
          <input type="text" class="form-control" name="" required placeholder="Title Meta" value="*Meta Tag SEO" readonly="">
        </div>
      </div>
      <div class="col-md-2">
        <div class="btn btn-icon btn-success mr-1 mb-1 waves-effect waves-light addData" style="margin-top:25px"><i class="flaticon-add-circular-button"></i></div>
      </div>

    </div>
    @if($records)
    @if($records->count() > 0)
    @foreach($records as $k => $value)
    <div class="row totalData" data-no="{{$k+1}}" id="data{{$k+1}}">
     <div class="col-md-10">
      <input type="hidden" name="flag[id][{{ $k+1 }}]" value="{{ $value->id }}">
      <div class="form-group">
        <label>{{ __('Title Meta') }}</label>
        <input type="text" class="form-control" name="flag[{{ $attribute }}][{{ $k+1 }}]" required placeholder="Title Meta" value="{{$value->title}}" placeholder="{{ $attribute }}{{ $k+1 }}">
      </div>
    </div>
    <div class="col-md-2">
      <div class="btn btn-icon btn-success waves-effect waves-light addData" style="margin-top:25px"><i class="flaticon-add-circular-button"></i></div>
      <div class="btn btn-icon btn-danger waves-effect waves-light deleteData" style="margin-top:25px" data-length="data{{$k+1}}" data-id="{{ $value->id }}"><i class="flaticon-close" ></i></div>
    </div>
  </div>
  @endforeach
  @endif
  @endif
  <div class="appendDelete">
    
  </div>
</div> 
</div>
</div>

<script type="text/javascript">
 $(document).on('click','.addData',function(){
  var no = $('.totalData:last').data('no')+1;
  console.log('no',no)
  $('.appendData').append(`
    <div class="row totalData" data-no="`+no+`" id="data`+no+`">
    <div class="col-md-10">
    <div class="form-group">
    <label>{{ __('Title Meta') }}</label>
    <input type="text" class="form-control" name="flag[{{ $attribute }}][`+no+`]" required placeholder="Title Meta" >
    </div>
    </div>
    <div class="col-md-2">
    <div class="btn btn-icon btn-success waves-effect waves-light addData" style="margin-top:25px"><i class="flaticon-add-circular-button"></i></div>
    <div class="btn btn-icon btn-danger waves-effect waves-light deleteData" style="margin-top:25px" data-length="data`+no+`"><i class="flaticon-close" ></i></div>
    </div>
    </div>
    `);
});

$(document).on('click','.deleteData',function(){
  var dataDel = $(this).data('length');
  var dataId = $(this).data('id');
  $('.appendDelete').append(`
    <input type="hidden" name="flag[idDel][]" value="`+dataId+`">
  `)
  $('#'+dataDel).remove();
});

</script>
