@extends('layouts.admin')

@section('title', 'Create New product')

@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="card card-light">
            <div class="card-header">
                <h3 class="card-title">New product</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('products.update', $product->id) }}" method="POST"
            enctype="multipart/form-data">
            @method('put')
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="name" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                         @enderror
                    </div>
                    <div class="form-group">
                        <label>Select</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                          <option value="">No Category</option>
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (old('category_id', $product->category_id) == $category->id ) selected @endif>{{ $category->name }}</option>
                          @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}">
                        @error('price')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Sale Price</label>
                        <input type="number" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}">
                        @error('sale_price')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Quantitiy</label>
                        <input type="number" class="form-control @error('quantitiy') is-invalid @enderror" id="quantitiy" name="quantitiy" value="{{ old('quantitiy', $product->quantitiy) }}">
                        @error('quantitiy')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">SKU</label>
                        <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
                        @error('sku')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Weight</label>
                        <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $product->weight) }}">
                        @error('weight')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Width</label>
                        <input type="number" class="form-control @error('width') is-invalid @enderror" id="width" name="width" value="{{ old('width', $product->width) }}">
                        @error('width')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Height</label>
                        <input type="number" class="form-control @error('height') is-invalid @enderror" id="height" name="height" value="{{ old('height', $product->height) }}">
                        @error('height')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Length</label>
                        <input type="number" class="form-control @error('length') is-invalid @enderror" id="length" name="length" value="{{ old('length', $product->length) }}">
                        @error('length')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="exampleInputFile" name="image">
                                <label class="custom-file-label" for="exampleInputFile">Choose Image</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="Active" @if (old('status', $product->status) == 'Active') checked @endif>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" value="Draft" @if (old('status', $product->status) == 'Draft') checked @endif>
                            <label class="form-check-label">Draft</label>
                        </div>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
