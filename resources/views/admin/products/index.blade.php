@extends('layouts.admin')

@section('title', 'products List')

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
                    <h3 class="card-title">Products List</h3>
                    <div class="card-tools">
                        <a href="{{ route('products.trash') }}" class="btn btn-outline-dark ml-3">trash</a>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('products.create') }}" class="btn btn-outline-primary">Add</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Setting</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ $product->imageUrl }}" alt="{{ $product->name }}"
                                         width="100" height="50" style="object-fit: cover">
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->quantitiy }}</td>
                                <td>{{ $product->status }}</td>
                                <td>{{ $product->created_at->diffForHumans(now())}}</td>
                                <td>{{ $product->updated_at->diffForHumans(now()) }}</td>
                                <td>
                                    <a href="{{ route('products.edit', [$product->id]) }}"
                                       class="btn btn-outline-primary">Edit <i class="far fa-edit"></i></a>
                                    {{--                              <a href="#" onclick = "confirmDelete(this,'{{ $product->id }}')" class="btn btn-outline-danger">delete <i class="far fa-trash-alt"></i></a>--}}
                                    <form action="{{ route('products.destroy', [$product->id]) }}" method="POST"
                                          class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">delete <i
                                                class="far fa-trash-alt"></i></button>
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
            {{ $products->links() }}
        </div>

    </div>
@endsection


