@extends('layouts.admin')

@section('title', 'Roles List')

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
                    <h3 class="card-title">Roles List</h3>
                    <div class="card-tools">
                        @can('roles.create')
                            <a href="{{ route('roles.create') }}" class="btn btn-outline-primary">Add</a>
                        @endcan

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->price }}</td>
                                <td>{{ $role->created_at->diffForHumans(now())}}</td>
                                <td>{{ $role->updated_at->diffForHumans(now()) }}</td>
                                <td>
                                    @can('roles.update')
                                        <a href="{{ route('roles.edit', [$role->id]) }}"
                                           class="btn btn-outline-primary">Edit <i class="far fa-edit"></i></a>
                                    @endcan
                                    {{--                              <a href="#" onclick = "confirmDelete(this,'{{ $product->id }}')" class="btn btn-outline-danger">delete <i class="far fa-trash-alt"></i></a>--}}
                                        @can('roles.delete')

                                    <form action="{{ route('roles.destroy', [$role->id]) }}" method="POST"
                                          class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">delete <i
                                                class="far fa-trash-alt"></i></button>
                                    </form>
                                        @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            {{ $roles->links() }}
        </div>

    </div>
@endsection


