@php use Carbon\Carbon; @endphp


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

        <div class="col-sm-12 ">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">

                        @php 
                        $i=0; 
                        $newStart = '';
                        $newEnd = '';
                        @endphp
                        @foreach($records as $k => $value)
                        @php 
                        if(isset($value->start_at)){
                        $newStart = Carbon::createFromTimeString($value->start_at)->format('H:i'); 
                    }

                    if(isset($value->end_at)){
                    $newEnd = Carbon::createFromTimeString($value->end_at)->format('H:i');
                }

                @endphp
                
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">

                                <input type="text" class="form-control" name="{{ $attribute }}[{{$i}}][day_name]" value="{{$value->day_name}}" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[{{$i}}][start_at]" title="Jam Buka" value="{{ $newStart }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[{{$i}}][end_at]" title="Jam Tutup" value="{{ $newEnd }}">
                            </div>
                        </div>                               
                    </div>

                </div>
                @php $i++; @endphp

                @endforeach

            </div>
        </div>
    </div>
</div>
@else
<div class="col-sm-12 ">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- Senin -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">

                                <input type="text" class="form-control" name="{{ $attribute }}[0][day_name]" value="Senin" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[0][start_at]" title="Jam Buka" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">

                                <input type="time" class="form-control" name="{{ $attribute }}[0][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Selasa -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[1][day_name]" value="Selasa" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[1][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[1][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Rabu -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[2][day_name]" value="Rabu" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[2][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[2][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Kamis -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[3][day_name]" value="Kamis" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[3][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[3][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Jum'at -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[4][day_name]" value="Jum'at" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[4][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[4][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Sabtu -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[5][day_name]" value="Sabtu" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[5][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[5][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Minggu/Ahad -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[6][day_name]" value="Minggu/Ahad" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[6][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[6][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endif
@else


<div class="col-sm-12 ">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <!-- Senin -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">

                                <input type="text" class="form-control" name="{{ $attribute }}[0][day_name]" value="Senin" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[0][start_at]" title="Jam Buka" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">

                                <input type="time" class="form-control" name="{{ $attribute }}[0][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Selasa -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[1][day_name]" value="Selasa" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[1][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[1][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Rabu -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[2][day_name]" value="Rabu" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[2][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[2][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Kamis -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[3][day_name]" value="Kamis" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[3][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[3][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Jum'at -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[4][day_name]" value="Jum'at" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[4][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[4][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Sabtu -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[5][day_name]" value="Sabtu" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[5][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[5][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
                <!-- Minggu/Ahad -->
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{ $attribute }}[6][day_name]" value="Minggu/Ahad" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[6][start_at]" title="Jam Buka">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="time" class="form-control" name="{{ $attribute }}[6][end_at]" title="Jam Tutup">
                            </div>
                        </div>                               
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endif
</div>
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
