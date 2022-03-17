<form action="{{ route($route.'.history',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Teruskan</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="keluhan" class="">{{ __('Ruas') }}</label>
                    @php
                        $regional = $record->ruas->ro->regional->name;
                        $ruas = $record->ruas->name;
                        $ro = $record->ruas->ro->name;
                        $ruasName = $regional.' - '.$ruas.' - '.$ro;
                    @endphp
                    <input id="ruas_id" type="text" readonly class="form-control" name="ruas_id" value="{{ $ruasName }}">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="bidang" class="">{{ __('Service Provider') }}</label>
                    {{-- <select class="form-control select2" name="unit_id">
                        {!! App\Models\MasterUnit::options('unit','id',['filters' => [function($q){
                            $q->where('type',1);
                        }]],'( Ruas Jalan Tol )') !!}
                    </select> --}}
                    <select class="form-control option-ajax select2" id="unit" name="unit_id">
                        {!! App\Models\MasterUnit::options('unit','id',['selected' => $record->unit_id, 'filters' => ['unit_id' => $record->unit->unit_id]],'( Pilih Unit)') !!}
                    </select>
                </div>
            </div>

        </div>

    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <em class="flaticon-circle"></em>
        Tutup
    </button>
    <button type="button" class="btn btn-light-success font-weight-bold mr-2 save">
        <em class="flaticon-add-circular-button"></em>
        Simpan
    </button>
</div>

</form>
