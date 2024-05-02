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
            <div class="text-center">
                <img src="{{ asset('storage/blog/'.$blog->image) }}" class="img-thumbnail" width="300px" alt="">
            </div>
            <div class="mt-3">
                <h4>{{ $blog->title }} <b class="ml-5">{{ $blog?->category?->name }}</b></h4>
            </div>
            <div class="mt-3">
                <p>{{ $blog->short_description }}</p>
            </div>
            <div class="mt-5">
                <p>{!! $blog->long_description !!}</p>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('partial.script')
@endsection