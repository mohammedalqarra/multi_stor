@extends('admin.index')

@section('title', 'Products |' . env('APP_NAME'))

@section('breadcrumb')
    <h1 class="breadcrumb-item active">All Products</h1>
@endsection


@section('content')


    {{-- <div class="mb-5">
        <a href="{{ route('products.create') }}" class="btn btn-lg btn-outline-primary w-25">Create</a>
        <a href="{{ route('products.trash') }}" class="btn btn-lg btn-outline-dark w-25">Trash</a>

    </div> --}}

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />
    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
            <x-form.input name="name" placeholder="Search here..." class="mx-2"  :value="request('name')" />

            <select name="status" class="form-control mx-2">
                <option value="">All</option>
                <option value="active" @selected(request('status') == 'active')>active</option>
                <option value="archived" @selected(request('status') == 'archived')>archived</option>
            </select>

            <button class="btn btn-dark px-5">Search</button>


    </form>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-dark text-white">
                <th>ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Parent</th>
                <th>Status</th>
                <th>Create At</th>
                <th>Actions</th>
                {{-- <th colspan="2"></th> --}}
            </tr>
        </thead>
        <tbody>
            @if ($products->count() > 0)
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td> <img width="80" src="{{ asset('storage/' . $product->image) }}" alt="50"></td>
                        <td>{{ $product->parent_name }}</td>
                        <td>{{ $product->status }}</td>
                        <td>{{ $product->created_at ? $product->created_at->diffForHumans() : '' }}</td>
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary"><i
                                    class="fa fa-edit"></i>edit</a>
                            {{-- confirm delte --}}
                            <button class="btn btn-sm btn-outline-danger btn-delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                            <form class="d-line" action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                <!-- Form Method Spoofing  -->
                                <input type="hidden" name="_method" value="delete">
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7">No products defined</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{-- {{ $products->withQueryString()->links() }} --}}

    {{ $products->appends($_GET)->links() }}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <script>
        $('.btn-delete').on('click', function() {
            let form = $(this).next('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        });
    </script>
@stop
