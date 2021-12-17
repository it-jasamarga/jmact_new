
<div class="card card-custom mb-5">
 <div class="card-header card-header-right ribbon ribbon-clip ribbon-left">
  <div class="ribbon-target" style="top: 12px;">
    <span class="ribbon-inner bg-success"></span>{{ $title }}
  </div>
</div>
<div class="card-body">
    <div class="row append{{ $attribute }}" style="max-height: 500px;overflow-y: scroll;">
        @if($records)
            @if(count($records) > 0)
                @foreach($records as $k => $value)
                    <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="hidden" class="fileId{{ $k+1 }}" name="fileId[{{ $k+1 }}]" value="{{ $value->id }}" />
                                        <input type="file" name="{{ $attribute }}[{{ $k+1 }}]" id="input-file-max-fs" class="dropify" data-remove="fileId{{ $k+1 }}" data-max-file-size="10M" data-allowed-file-extensions="{{ ($extentions) ? $extentions : 'jpg png gif jpeg ico' }}" data-default-file="{{ asset('storage/'.$value->url) }}" data-show-remove="true" />
                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if(count($records) < $total)
                @php
                    $hasilTotal = ($total - count($records));
                @endphp
                @if($hasilTotal && ($hasilTotal > 0))
                @php
                    $no = count($records);
                    $no++
                @endphp
                @for($i = $no; $i <= $total; $i++)
                    <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-group">
                                        
                                        <input type="file" name="{{ $attribute }}[{{ $i }}]" id="input-file-max-fs" class="dropify" data-max-file-size="10M" data-allowed-file-extensions="{{ ($extentions) ? $extentions : 'jpg png gif jpeg ico' }}" data-default-file="" data-show-remove="false" />
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                @endif
                @endif
            @else
                @if($total && ($total > 0))
                @for($i = 0; $i < $total; $i++)
                    <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="file" name="{{ $attribute }}[{{ $i+1 }}]" id="input-file-max-fs" class="dropify" data-max-file-size="10M" data-allowed-file-extensions="{{ ($extentions) ? $extentions : 'jpg png gif jpeg ico' }}" data-default-file="" data-show-remove="false" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                @endif
            @endif
        @else
            @if($total && ($total > 0))
            @for($i = 0; $i < $total; $i++)
                <div class="col-xl-4 col-md-6 col-sm-12 mb-3">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="file" name="{{ $attribute }}[{{ $i+1 }}]" id="input-file-max-fs" class="dropify" data-max-file-size="10M" data-allowed-file-extensions="{{ ($extentions) ? $extentions : 'jpg png gif jpeg ico' }}" data-default-file="" data-show-remove="false" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            @endfor
            @endif
        @endif
    </div>
</div>


@section('scripts')
<script type="text/javascript">
    $(document).on('click','.dropify-clear',function(){
        var removeFileId = $(this).prev().data('remove');
        $('.'+removeFileId).remove();
    });
</script>
@endsection