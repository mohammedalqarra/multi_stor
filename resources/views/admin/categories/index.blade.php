@extends('admin.index')

@section('title', 'Categories |' . env('APP_NAME'))

@section('breadcrumb')
    <li class="breadcrumb-item active">All Categories</li>
@endsection


@section('content')
    <form action="{{ route('categories.index') }}" method="get">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search here..." name="category"
                value="{{ request()->category }}">
            <button class="btn btn-dark px-5" id="button-addon2">Search</button>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-dark text-white">
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Create At</th>
                <th>Actions</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @if ($categories->count() > 0)
                @foreach ($categories as $category)
                    <tr>
                        <td></td>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->parent_id }}</td>
                        <td>{{ $category->created_at ? $category->diffForHumans() : '' }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-succes"><i
                                    class="fa fa-edit"></i>edit</a>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger btn-delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
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
                    <td colspan="7">No categories defined</td>
                </tr>
            @endif
        </tbody>
    </table>

   {{-- {{ $categories->appends($_GET)->links() }} --}}

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
