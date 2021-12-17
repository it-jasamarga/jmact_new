@php use Carbon\Carbon; @endphp


<div class="card card-custom mb-5">
    <div class="card-header card-header-right ribbon ribbon-clip ribbon-left">
        <div class="ribbon-target" style="top: 12px;">
            <span class="ribbon-inner bg-success"></span>{{ $title }}
        </div>
    </div>
    <div class="card-body">
        <div class="row append{{ $attribute }}" style="max-height: 500px;overflow-y: scroll;">

            @if(isset($records))
            
            @if(count($records) > 0)

            <div class="col-sm-12 ">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">

                            @php $i=0; @endphp
                            @foreach($records as $k => $value)
                            @php 
                            $newStart = Carbon::createFromTimeString($value->start_at); 
                            $newEnd = Carbon::createFromTimeString($value->end_at); 

                            @endphp

                            <!-- Carbon::createFromTime($value->start_at))}} -->
                            <!-- {{$i}}Senin -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[{{$i}}][day_name]" value="{{$value->day_name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[{{$i}}][status]">
                                                <option value="24 Jam" {{ ($value->status=="24 Jam") ? 'selected' : ''}}>24 Jam</option>
                                                <option value="Modifikasi" {{ ($value->status=="Modifikasi") ? 'selected' : ''}}>Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">

                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[{{$i}}][start_at]" title="Jam Buka" value="{{$newStart->format('H:i')}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[{{$i}}][end_at]" title="Jam Tutup" value="{{$newEnd->format('H:i')}}">
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
                                    <div class="col-sm-3">
                                        <div class="form-group">

                                            <input type="text" class="form-control" name="{{ $attribute }}[0][day_name]" value="Senin" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[0][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">

                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[0][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">

                                            <input type="time" class="form-control" name="{{ $attribute }}[0][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Selasa -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[1][day_name]" value="Selasa" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[1][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[1][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[1][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Rabu -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[2][day_name]" value="Rabu" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[2][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[2][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[2][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Kamis -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[3][day_name]" value="Kamis" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[3][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[3][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[3][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Jum'at -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[4][day_name]" value="Jum'at" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[4][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[4][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[4][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Sabtu -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[5][day_name]" value="Sabtu" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[5][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[5][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[5][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Minggu/Ahad -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[6][day_name]" value="Minggu/Ahad" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control myClass" name="{{ $attribute }}[6][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[6][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[6][end_at]" title="Jam Tutup" value="23:59">
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
                                    <div class="col-sm-3">
                                        <div class="form-group">

                                            <input type="text" class="form-control" name="{{ $attribute }}[0][day_name]" value="Senin" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[0][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">

                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[0][start_at]" title="Jam Buka" value="00:00" >
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">

                                            <input type="time" class="form-control" name="{{ $attribute }}[0][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Selasa -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[1][day_name]" value="Selasa" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[1][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[1][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[1][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Rabu -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[2][day_name]" value="Rabu" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[2][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[2][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[2][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Kamis -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[3][day_name]" value="Kamis" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[3][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[3][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[3][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Jum'at -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[4][day_name]" value="Jum'at" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[4][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[4][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[4][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Sabtu -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[5][day_name]" value="Sabtu" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[5][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[5][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[5][end_at]" title="Jam Tutup" value="23:59">
                                        </div>
                                    </div>                               
                                </div>

                            </div>
                            <!-- Minggu/Ahad -->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{ $attribute }}[6][day_name]" value="Minggu/Ahad" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" name="{{ $attribute }}[6][status]">
                                                <option>Pilih Salah Satu</option>
                                                <option value="24Jam" selected >24 Jam</option>
                                                <option value="Modifikasi">Modifikasi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[6][start_at]" title="Jam Buka" value="00:00">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <input type="time" class="form-control" name="{{ $attribute }}[6][end_at]" title="Jam Tutup" value="23:59">
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
    $( ".myClass" ).css( "border", "3px solid red" );
</script>
@endsection
