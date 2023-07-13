@extends('layouts.dashboard')

@section('title', 'Create Role')

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Roles</li>
@endsection

@section('content')

<form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    @include('admin.roles._form')
</form>

@endsection
