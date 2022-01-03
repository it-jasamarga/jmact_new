<form action="{{ route($route.'.historyStage',$record->id) }}" method="POST" id="formData" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="modal-header">
        <h3 class="modal-title">Tahapan</h3>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="keluhan" class="">{{ __('Ruas') }}</label>
                    <select class="form-control select2" name="ruas_id">
                        {!! App\Models\MasterRuas::options(function($q){
                        $ro = ($q->ro) ? $q->ro->name : '-';
                        $regional = ($q->ro->regional) ? $q->ro->regional->name : '-';
                            return $q->name.' - '.$ro.' - '.$regional;
                        },'id',['filters' => [function($q) use($record){
                            $q->whereHas('ro',function($q1) use($record){
                                $q1->where('regional_id',$record->ruas->ro->regional->id);
                            });
                        }]],'( Ruas Jalan Tol )') !!}
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="bidang" class="">{{ __('Service Provider') }}</label>
                    <select class="form-control select2" name="provider">
                        <option value="">( Pilih Service Provider )</option>
                        <option value="Operasional">Operasional</option>
                        <option value="Konstruksi">Konstruksi</option>
                        <option value="Rest Area">Rest Area</option>
                    </select>
                </div>
            </div>

        </div>

    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">
        <i class="flaticon-circle"></i>
        Tutup
    </button>
    <button type="button" class="btn btn-light-success font-weight-bold mr-2 save">
        <i class="flaticon-add-circular-button"></i>
        Simpan
    </button>
</div>

</form>
