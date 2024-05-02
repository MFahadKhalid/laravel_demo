@extends('layouts.scaffold')
@push('title')
    {{ $title ?? '' }}
@endpush
@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
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
                        <a href="{{ route('blog.create') }}" class="btn btn-primary">Create blog</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table" class="table table-bordered table-hover">
                    <thead>
                        <th>ID</th>
                        @if (auth()->user()->role_id == '1')
                            <th>User</th>
                        @endif
                        <th>Category</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if (auth()->user()->role_id == '1')
                            @foreach ($blogs as $index=>$blog)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ $blog?->user?->name }}</td>
                                    <td>{{ isset($blog->category)? $blog->category->name : '-' }}</td>
                                    <td>{{ $blog->title }}</td>
                                    <td>
                                        @if ($blog->status == '1')
                                            <span class="badge bg-success text-light">Active</span>
                                        @else
                                            <span class="badge bg-danger text-light">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('blog.show',$blog->id) }}"><i class="text-info fa fa-eye"></i> </a>&nbsp;|&nbsp;
                                        <a href="{{ route('blog.edit',$blog->id) }}"><i class="text-success fa fa-edit"></i> </a>&nbsp;|&nbsp;
                                        <form action="{{ route('blog.destroy',$blog->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border: none; background-color: transparent;" onclick="return confirm('Are you sure you want to delete this data?')"><i class="text-danger fa fa-trash"></i></button>
                                        </form>     
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($userBlogs as $index=>$blog)
                                <tr>
                                    <td>{{ ++$index }}</td>
                                    <td>{{ isset($blog->category)? $blog->category->name : '-' }}</td>
                                    <td>{{ $blog->title }}</td>
                                    <td>
                                        @if ($blog->status == '1')
                                            <span class="badge bg-success text-light">Active</span>
                                        @else
                                            <span class="badge bg-danger text-light">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('blog.show',$blog->id) }}"><i class="text-info fa fa-eye"></i> </a>&nbsp;|&nbsp;
                                        <a href="{{ route('blog.edit',$blog->id) }}"><i class="text-success fa fa-edit"></i> </a>&nbsp;|&nbsp;
                                        <form action="{{ route('blog.destroy',$blog->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border: none; background-color: transparent;" onclick="return confirm('Are you sure you want to delete this data?')"><i class="text-danger fa fa-trash"></i></button>
                                        </form>     
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('partial.script')
@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
<script>
   $(document).ready(function () {
       $('#table').DataTable();
   });
</script>
@endpush
