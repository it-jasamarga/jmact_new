<form action="#" method="POST" id="formData" enctype="multipart/form-data">
    @method('PATCH')
    @csrf

    <input type="hidden" name="id" value="{{ $record->id }}">
    <div class="modal-header">
        <h3 class="modal-title">Detail Data</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="card-body pt-4" >
                <table class="table table-bordered">
                    <tr class="bg-dark text-white">
                        <td colspan="2">INFO</td>
                    </tr>
                    <tr>
                        <td width='30%'>Type</td>
                        <td>{!! eventType($record->event) !!}</td>
                    </tr>
                    <tr>
                        <td>Model</td>
                        <td>{{ $record->auditable_type }}</td>
                    </tr>
                    <tr>
                        <td>Time</td>
                        <td>{{ Carbon\Carbon::parse($record->created_at)->diffForHumans() . " - ". $record->created_at->format('Y F d H:i:s') }}</td>
                    </tr>
                    <tr>
                        <td>Done By</td>
                        <td>{{ ($record->user) ? $record->user->name : '-' }} - {{ ($record->user) ? $record->user->email : '' }}</td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr class="bg-dark text-white">
                        <td width='33%'>Field</td>
                        <td width='33%'>Old Values</td>
                        <td width='33%'>New Values</td>
                    </tr>
                    @forelse ($old_values as $key => $item)
                        @if (@$new_values)
                            @if ($item == $new_values[$key])
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $item }}</td>
                                    <td>{{ $new_values[$key] }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td class="bg-warning text-white">{{ $item }}</td>
                                    <td class="bg-warning text-white">{{ $new_values[$key] }}</td>
                                </tr>
                            @endif
                        @else
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $item }}</td>
                                <td class="text-center">-</td>
                            </tr>
                        @endif
                    @empty
                        @foreach ($new_values as $key => $item)
                            <tr>
                                <td>{{ $key }}</td>
                                <td class="text-center">-</td>
                                <td>{{ $item }}</td>
                            </tr>
                        @endforeach
                    @endforelse
                </table>
            </div>

        </div>
    </div>
</div>

</div>

</form>
