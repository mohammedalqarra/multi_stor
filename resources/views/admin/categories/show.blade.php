@extends('admin.master')

@section('title', $category->name)

@section('breadcrumb')
    <h1 class="breadcrumb-item active">show Categories</h1>
    <h1 class="breadcrumb-item active">{{ $category->name }}</h1>
@endsection


@section('content')
    <table class="table table-bordered">
        <thead>
            <tr class="bg-dark text-white">
                <th>Name</th>
                <th>Image</th>
                <th>Store</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @php
                $products = $category->products()->with('store')->latest()->paginate(2);
            @endphp
            @if ($category->products->count() > 0)
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td> <img width="80" src="{{ asset('storage/' . $category->image) }}" alt="50"></td>
                        <td>{{ $product->store->name }}</td>
                        <td>{{ $product->status }}</td>
                        <td>{{ $product->created_at ? $category->created_at->diffForHumans() : '' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5">No categories defined</td>
                </tr>
            @endif
        </tbody>


    </table>
    {{ $products->links() }}
@stop
