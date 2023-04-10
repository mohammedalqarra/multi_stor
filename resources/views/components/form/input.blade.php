<input type="{{ $type ?? 'Text'}}" name="{{ $name }}" placeholder="name" @class(['form-control', 'is-invalid' => $errors->has($name)])
    value="{{ old($name, $value) }}" />

@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
