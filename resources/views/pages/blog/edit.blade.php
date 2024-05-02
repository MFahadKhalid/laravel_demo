@extends('layouts.scaffold')
@push('title')
    {{ $title ?? '' }}
@endpush
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h3>{{ $title ?? '' }}</h3>
                </div>
                <div class="col-md-6">
                    <div class="float-right">
                        <a href="{{ route('blog.index') }}" class="btn btn-primary">Blog</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('blog.update',$blog->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class=" mt-3 col-md-6 col-6">
                        <label for="category">Category</label>
                        <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">Please select</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if($category->id == $blog->category_id) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" mt-3 col-md-6 col-6">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ $blog->title }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" mt-3 col-md-12 col-12">
                        <label for="short_description">Short Description</label>
                        <textarea name="short_description" id="short_description" class="form-control @error('short_description') is-invalid @enderror" cols="30" rows="3">{{ $blog->short_description }}</textarea>
                        @error('short_description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" mt-3 col-md-12 col-12">
                        <label for="long_description">Long Description</label>
                        <textarea name="long_description" id="long_description" class="form-control @error('long_description') is-invalid @enderror" cols="30" rows="3">{{ $blog->long_description }}</textarea>
                        @error('long_description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" mt-3 col-md-6 col-6">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                        @if(!empty($blog->image))
                            <img src="{{asset('storage/blog/'.$blog->image)}}" alt="" width="150px" class="img-thumbnail mt-3">
                        @endif
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" mt-3 col-md-6 col-6">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">Please Select</option>
                            <option value="1" @if($blog->status == '1') selected @endif>Active</option>
                            <option value="0" @if($blog->status == '0') selected @endif>Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mt-3 col-md-12">
                        <div class="float-right">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    @include('partial.script')
@endsection
@push('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js"></script>
<script>
    tinymce.init({ selector:'#long_description' });
</script>
@endpush