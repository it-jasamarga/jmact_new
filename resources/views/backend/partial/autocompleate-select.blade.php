<fieldset>
	<div class="input-group">
		<input type="text" class="form-control name{{ ($class) ? $class : '' }}" placeholder="Pilih Pengguna" readonly="" aria-describedby="button-addon2" readonly value="{{ ($value) ? $value : '' }}">
      	<input type="hidden" class="form-control id{{ ($class) ? $class : '' }}" placeholder="Pilih Pengguna" aria-describedby="button-addon2" name="{{ ($name) ? $name : [] }}" readonly value="{{ ($id) ? $id : '' }}" data-post="{{ ($name) ? $name : [] }}">
		<div class="input-group-prepend">
			<button class="btn btn-light-success show-user-modal custome-modal" data-url="{{ ($urlData) ? $urlData : '' }}" data-modal="#largeModal" type="button">Pilih Pengguna</button>
		</div>
	</div>
</fieldset>