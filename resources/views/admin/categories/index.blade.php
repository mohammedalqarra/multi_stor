@extends('admin.index')

@section('title', 'Categories |' . env('APP_NAME'))

@section('breadcrumb')
    <h1 class="breadcrumb-item active">All Categories</h1>
@endsection


@section('content')


    <div class="mb-5">
        @if (Auth::user()->can('categories.create'))
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-outline-primary mr-2">Create</a>
        @endif
        <a href="{{ route('admin.categories.trash') }}" class="btn btn-sm btn-outline-dark">Trash</a>
    </div>
    {{-- (session()->has('success')) --}}
    {{-- @if (session('msg'))
        <div class="alert alert-{{ session('type') }}">
            {{ session('msg') }}
            {{-- {{ session('success') }}
        </div>
    @endif --}}

    <x-alert type="success" />
    <x-alert type="info" />
    <x-alert type="danger" />
    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        {{-- <input type="text" class="form-control" placeholder="Search here..." name="category"
                value="{{ request()->category }}">
            <button class="btn btn-dark px-5" id="button-addon2">Search</button> --}}
        <x-form.input name="name" placeholder="Search here..." class="mx-2" :value="request('name')" />

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
                <th>Products #</th>
                <th>Status</th>
                <th>Create At</th>
                <th>Actions</th>
                {{-- <th colspan="2"></th> --}}
            </tr>
        </thead>
        <tbody>
            @if ($categories->count() > 0)
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td> <a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a> </td>
                        <td> <img width="80" src="{{ asset('storage/' . $category->image) }}" alt="50"></td>
                        {{-- <td>{{ $category->parent_name }}</td> --}}
                        <td>{{ $category->parent->name }}</td>
                        <td>{{ $category->products_number }}</td>
                        <td>{{ $category->status }}</td>
                        <td>{{ $category->created_at ? $category->created_at->diffForHumans() : '' }}</td>
                        <td>
                            @can('categories.update')
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-edit"></i>edit</a>
                            @endcan
                            {{-- confirm delte --}}
                            <button class="btn btn-sm btn-outline-danger btn-delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                            @can('categories.delete')
                                <form class="d-line" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    <!-- Form Method Spoofing  -->
                                    <input type="hidden" name="_method" value="delete">
                                    @method('delete')
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="9">No categories defined</td>
                </tr>
            @endif
        </tbody>
    </table>
    {{-- {{ $categories->withQueryString()->links() }} --}}

    {{ $categories->appends($_GET)->links() }}

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
