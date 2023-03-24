@extends('admin.master')

@section('title', 'Categories |' . env('APP_NAME'))

@section('breadcrumb')
    <h1 class="breadcrumb-item active">Create new Categories</h1>
@endsection

@include('admin.errors')

@section('content')

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="">Category name</label>
            <input type="text" name="name" placeholder="name" class="form-control" />
        </div>
        <div class="form-group">
            <label for="">Category Parent</label>
            <select name="parebt_id" class="form-control  form-select">
                <option value="">Select Category</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <textarea  name="description" class="myeditor" rows="10"></textarea>
        </div>
        <div class="form-group">
            <label for="">Image</label>
            <input type="file" id="image" name="image" class="form-control" />
        </div>
        <div class="form-group">
            <label for="">Status</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status"  value="active"
                        checked>
                    <label class="form-check-label">
                        Action
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status"  value="archived">
                    <label class="form-check-label">
                        Archived
                    </label>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success px-5 mb-5">Add</button>
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
