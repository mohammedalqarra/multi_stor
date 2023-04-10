@include('admin.errors')

<div class="form-group">

    {{-- <input type="text" name="name" placeholder="name" class="form-control @error('name') is-invalid @enderror"  value="{{ $category->name }}" /> --}}
    {{-- <input type="text" name="name" placeholder="name" @class([
        'form-control',
        'is-invalid' => $errors->has('name'),
    ]) value="{{ old('name' , $category->name ) }}" />

    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror --}}
    <x-form.input label="Category Name" name="name" class="form-control-lg" role="input" :value="$category->name" />
</div>
<div class="form-group">
    <label for="">Category Parent</label>
    <select name="parent_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id) == $parent->id)>{{ $parent->name }}</option>
        @endforeach
    </select>

</div>
<div class="form-group">
    <x-form.textarea name="description" label="Description" class="myeditor" rows="10" :value="$category->description" />
</div>
<div class="form-group">

    <x-form.input label="Image" type="file" id="image" name="image" class="form-control" accept="image/*" />
    @if ($category->image)
        <img src="{{ asset('storage/' . $category->image) }}" class="w-25" alt="50">
    @endif
</div>
<div class="form-group">
    <label for="">Status</label>
    <div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="active"
                @checked(old('status', $category->status)) =='active' )>
            <label class="form-check-label">
                Action
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="status" value="archived"
                @checked(old('status', $category->status)) =='archived' )>
            <label class="form-check-label">
                Archived
            </label>
        </div>
    </div>



</div>
<button type="submit" class="btn btn-success px-5 mb-5">{{ $button_label ?? 'Save' }}</button>
