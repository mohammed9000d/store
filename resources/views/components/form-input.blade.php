<lable for="{{ $id ?? $name }}">{{ $lable }}</lable>
<input type="{{ $type ?? 'text' }}"
       class="form-control @error($name) is-invalid @enderror"
       name="{{ $name }}"
       id="{{ $id ?? $name }}"
       value="{{ old($name, $value ?? null) }}">
@error($name)
<p class="invalid-feedback">{{ $message }}</p>
@enderror
