@extends('admin.master')

@section('title', 'Profile |' . env('APP_NAME'))

@section('breadcrumb')

    <h1 class="breadcrumb-item active">Pofile</h1>
    <h1 class="breadcrumb-item active">Edit Profile</h1>
@endsection


@section('content')
<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

</form>


@stop
