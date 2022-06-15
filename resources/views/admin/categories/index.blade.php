@extends('layouts.admin')

@section('title', 'Categories List')

@section('content')
<div class="row">
    <div class="col-12">

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Responsive Hover Table</h3>

          <div class="card-tools">
            <a href="{{ route('categories.create') }}" class="btn btn-outline-primary">Add</a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Slug</th>
                  <th>Description</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Setting</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($categories as $category)
                      <tr>
                          <td>{{ $category->id }}</td>
                          <td>{{ $category->name }}</td>
                          <td>{{ $category->slug }}</td>
                          <td>{{ $category->description }}</td>
                          <td>{{ $category->status }}</td>
                          <td>{{ $category->created_at->diffForHumans(now())}}</td>
                          <td>{{ $category->updated_at->diffForHumans(now()) }}</td>
                          <td>
                               <a href="{{ route('categories.edit', [$category->id]) }}" class="btn btn-outline-primary">Edit <i class="far fa-edit"></i></a>
                              <a href="{{ route('categories.destroy', [$category->id]) }}" class="btn btn-outline-danger">delete <i class="far fa-trash-alt"></i></a>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
@endsection


