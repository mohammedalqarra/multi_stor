@extends('admin.index')

@section('title', 'Products |' . env('APP_NAME'))

@section('breadcrumb')
    <h1 class="breadcrumb-item">Proucts</h1>
    <h1 class="breadcrumb-item active">Add Proucts</h1>
@endsection


@section('content')
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
                @include('admin.products._form',
                    'button_label' => 'Add'
                )
    </form>
@endsection
