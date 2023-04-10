@props(['type' => 'Text', 'name', 'value' => '' , 'label' => false])

@if ($label)
    <label for="">{{ $label }}</label>
@endif

<input type="{{ $type  }}" name="{{ $name }}" placeholder="name" {{-- @class(['form-control', 'is-invalid' => $errors->has($name)]) --}}
    value="{{ old($name, $value) }}" {{ $attributes->class([
        'form-control',
        'is-valid' => $errors->has($name)
    ]) }} />

@error($name)
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
