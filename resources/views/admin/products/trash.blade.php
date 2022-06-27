@extends('layouts.admin')

@section('title', 'Products Trash List')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product Trash list</h3>
                    <div class="card-tools d-flex justify-between align-items-center">
                        <form action="{{ route('products.restore') }}" method="POST"
                              class="mr-2">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-info"{{ $products->total() == 0 ? 'disabled' : '' }}>Restore All</button>
                        </form>
                        <form action="{{ route('products.force-delete') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" {{ $products->total() == 0 ? 'disabled' : '' }}>Empty Trash</button>
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Deleted At</th>
                            <th>Setting</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->quantitiy }}</td>
                                <td>{{ $product->status }}</td>
                                <td>{{ $product->deleted_at->diffForHumans(now())}}</td>
                                <td>
                                    <form action="{{ route('products.restore', [$product->id]) }}" method="POST"
                                          class="d-inline-block">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-outline-info">Restore</button>
                                    </form>
                                    <form action="{{ route('products.force-delete', [$product->id]) }}" method="POST"
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
            {{ $products->links() }}
        </div>

    </div>
@endsection


