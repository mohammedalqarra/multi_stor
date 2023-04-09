{{-- <div>
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
</div> --}}


{{-- @if (session('msg'))
<div class="alert alert-{{ session('type') }}">
    {{ session('msg') }}
    {{-- {{ session('success') }}
</div>
@endif --}}


@if (session()->has($type))
    <div class="aler alert-{{ $type }}">
        {{ session($type) }}
    </div>
@endif
