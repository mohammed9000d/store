<label>{{ $lable }}</label>
<select class="form-control @error($name) is-invalid @enderror" name="{{ $name }}">
    <option value="">-- Select --</option>
    @foreach ($options as $value => $text)
        <option value="{{ $value }}" @if (old($name, $selected) == $value ) selected @endif>{{ $text }}</option>
    @endforeach
</select>
@error($name)
<p class="text-danger">{{ $message }}</p>
@enderror
