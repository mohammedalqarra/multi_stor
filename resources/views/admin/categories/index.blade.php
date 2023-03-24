@extends('admin.index')

@section('title', 'Categories')

@section('breadcrumb')
    <li class="breadcrumb-item active">Categories</li>
@endsection


@section('content')
    <form action="{{ route('categories.index') }}" method="get">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search here..." name="category"
                value="{{ request()->category }}">
            <button class="btn btn-dark px-5" id="button-addon2">Search</button>
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Create At</th>
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
                        <td>{{ $category->created_at }}</td>
                        <td>
                            <a href="{{ route('categories.edit') }}" class="btn btn-sm btn-outline-succes">edit</a>
                        </td>
                        <td>
                            <form action="{{ route('categories.destroy') }}" method="POST">
                                @csrf
                                <!-- Form Method Spoofing  -->
                                <input type="hidden" name="_method" value="delete">
                                @method('delete')
                                <button class="btn btn-sm btn-outline-danger">
                                    Delete
                                </button>
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

@stop
