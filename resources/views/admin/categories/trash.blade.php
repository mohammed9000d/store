@extends('layouts.admin')

@section('title', 'Categories Trash List')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories Trash list</h3>
                    <div class="card-tools d-flex justify-between align-items-center">
                        <form action="{{ route('categories.restore') }}" method="POST"
                              class="mr-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-info"{{ $categories->total() == 0 ? 'disabled' : '' }}>Restore All</button>
                        </form>
                        <form action="{{ route('categories.force-delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" {{ $categories->total() == 0 ? 'disabled' : '' }}>Empty Trash</button>
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Parent Name</th>
                            <th>Status</th>
                            <th>Deleted At</th>
                            <th>Setting</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->parent_id }}</td>
                                <td>{{ $category->status }}</td>
                                <td>{{ $category->deleted_at->diffForHumans(now())}}</td>
                                <td>
                                    <form action="{{ route('categories.restore', [$category->id]) }}" method="POST"
                                          class="d-inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-info">Restore</button>
                                    </form>
                                    <form action="{{ route('categories.force-delete', [$category->id]) }}" method="POST"
                                          class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Delete Forever</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            {{ $categories->links() }}
        </div>

    </div>
@endsection


