<div class="form-floating mb-3">
	<input value="{{ old($name) }}" type="{{ $type ?? 'text' }}" class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $id = "$name-input" }}" placeholder="{{ $placeholder = __("validation.attributes.$name") }}">
	<label for="{{ $id }}">{{ $placeholder }}</label>

	@error($name)
	    <div class="invalid-feedback">{{ $message }}</div>
	@enderror
</div>
