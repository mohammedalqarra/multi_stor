@extends('admin.index')

@section('title', 'Products |' . env('APP_NAME'))

@section('breadcrumb')
    <h1 class="breadcrumb-item">Proucts</h1>
    <h1 class="breadcrumb-item active">Edit Proucts</h1>
@endsection


@section('content')
    <form action="{{ route('products.update', $product->id ) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            @include('admin.products._form' ,
                'button_label' => 'Update'
            )
    </form>
@endsection
