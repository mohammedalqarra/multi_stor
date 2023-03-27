@extends('admin.master')

@section('title', 'Categories |' . env('APP_NAME'))

@section('breadcrumb')
    <h1 class="breadcrumb-item active">Edit Categories</h1>

    @if (session('msg'))
        <div class="alert alert-{{ seesion('type') }}">
            {{ seesion('msg') }}
        </div>
    @endif
@endsection

@include('admin.errors')

@section('content')

    <form action="{{ route('categories.update', $category-> id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Category name</label>
            <input type="text" name="name" placeholder="name" class="form-control" value="{{ $category->name }}" />
        </div>
        <div class="form-group">
            <label for="">Category Parent</label>
            <select name="parent_id" class="form-control form-select">
                <option value="">Primary Category</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @selected($category->parent_id ==
                        $parent->id)>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" class="myeditor" rows="10">{{ $category->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="">Image</label>
            <input type="file" id="image" name="image" class="form-control" />
        </div>
        <div class="form-group">
            <label for="">Status</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="active"
                        @checked($category->status == 'active')>
                    <label class="form-check-label">
                        Action
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="archived"
                        @checked($category->status == 'archived')>
                    <label class="form-check-label">
                        Archived
                    </label>
                </div>
            </div>



        </div>
        <button type="submit" class="btn btn-success px-5 mb-5">Update</button>
    </form>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.3.1/tinymce.min.js"
        integrity="sha512-eV68QXP3t5Jbsf18jfqT8xclEJSGvSK5uClUuqayUbF5IRK8e2/VSXIFHzEoBnNcvLBkHngnnd3CY7AFpUhF7w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        tinymce.init({
            selector: '.myeditor'
        });
    </script>
@stop
@stop
