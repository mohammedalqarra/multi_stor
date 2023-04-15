@extends('admin.index')

@section('title', 'Trash Categories |' . env('APP_NAME'))

@section('breadcrumb')
    <h1 class="breadcrumb-item">Categories</h1>
    <h1 class="breadcrumb-item active">Trash Categories</h1>
@endsection

@section('content')

    <div class="mb-5">
        <a href="{{ route('categories.index') }}" class="btn btn-lg btn-outline-primary w-25">Back</a>
    </div>
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
                <th>Status</th>
                <th>Deleted At</th>
                <th>Actions</th>
                {{-- <th colspan="2"></th> --}}
            </tr>
        </thead>
        <tbody>
            @if ($categories->count() > 0)
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td> <img width="80" src="{{ asset('storage/' . $category->image) }}" alt="50"></td>
                        <td>{{ $category->status }}</td>
                        <td>{{ $category->deleted_at }}</td>
                        <td >
                            <form action="{{ route('categories.restore' , $category->id) }}"  method="POST">
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-sm btn-outline-info"><i class="fas fa-trash-restore"></i>Restore</button>
                            </form>
                        </td>
                        <td>
                            {{-- confirm delte --}}
                            <button class="btn btn-sm btn-outline-danger btn-delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                            <form  action="{{ route('categories.force-delete', $category->id) }}" method="POST">
                                @csrf
                                <!-- Form Method Spoofing  -->
                                @method('delete')
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7">No categories defined</td>
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
