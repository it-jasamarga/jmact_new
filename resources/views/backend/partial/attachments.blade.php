<div class="card card-custom mb-5">
 <div class="card-header card-header-right ribbon ribbon-clip ribbon-left">
  <div class="ribbon-target" style="top: 12px;">
    <span class="ribbon-inner bg-success"></span>{{ $title }}
  </div>
</div>
<div class="card-body">
    <div class="row append{{ $attribute }}" style="max-height: 500px;overflow-y: scroll;">
        <div class="col-xl-4 col-md-6 col-sm-12 cek{{ $attribute }} delete{{ $attribute }}0" data-no="0">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-group">
                            <input type="file" id="input-file-max-fs" class="dropify" data-max-file-size="2M" data-allowed-file-extensions="jpg png gif jpeg ico" data-default-file="" data-show-remove="false" disabled="disabled"/>
                        </div>
                        <div class="btn btn-light-success font-weight-bold btn-block btn-block mt-2 add{{ $attribute }}">Tambah Data</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="appendID">
            
        </div>
        @if($records)
            @if(count($records) > 0)
                @foreach($records as $k => $value)
                    <div class="col-xl-4 col-md-6 col-sm-12 cek{{ $attribute }} delete{{ $attribute }}{{ $k+1 }}" data-no="{{ $k+1 }}">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="file" name="{{ $attribute }}[{{ $k+1 }}]" id="input-file-max-fs" class="dropify" data-max-file-size="10M" data-allowed-file-extensions="jpg png gif jpeg ico" data-default-file="{{ asset('storage/'.$value->url) }}" data-show-remove="false" />
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="btn btn-light-success font-weight-bold btn-block add{{ $attribute }}">Tambah</div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="btn btn-light-danger font-weight-bold btn-block hapus{{ $attribute }}" data-id="{{ $value->id }}" data-hapus=".delete{{ $attribute }}{{ $k+1 }}">Hapus</div>
                                        </div>
                                    </div>
                                </div>
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
    $(document).on('click','.add{{ $attribute }}',function(){
        var no = $('.cek{{ $attribute }}').last().data('no')+1;
        console.log('cekNo',no)
        $('.append{{ $attribute }}').append(`
            <div class="col-xl-4 col-md-6 col-sm-12 cek{{ $attribute }} delete{{ $attribute }}`+no+`" data-no="`+no+`">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="form-group">
                                <input type="file" name="{{ $attribute }}[`+no+`]" id="input-file-max-fs" class="dropify" data-max-file-size="10M" data-allowed-file-extensions="jpg png gif jpeg ico" data-default-file="" data-show-remove="false" />
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn btn-light-success font-weight-bold btn-block add{{ $attribute }}">Tambah</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="btn btn-light-danger font-weight-bold btn-block hapus{{ $attribute }}" data-hapus=".delete{{ $attribute }}`+no+`">Hapus</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `);
        $('.dropify').dropify();
    });

    $(document).on('click','.hapus{{ $attribute }}',function(){
        var data = $(this).data('hapus');
        $('.appendID').append('<input type="hidden" name="fileIdDel[]" value="'+$(this).data('id')+'">');
        $(data).remove();
    });
</script>
@endsection