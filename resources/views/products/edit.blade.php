@extends('products.layout')
     
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>
     
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form enctype="multipart/form-data"> 
        @csrf
        {{-- @method('PUT') --}}
     
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Category:</strong>
                    <select class="form-select my-4" value="{{$product->category}}" id="category" required name="category">
                                  <option value="{{$product->category}}">Select Category</option>
                                  <option value="Clothing">Clothing</option>
                                  <option value="Footwear">Footwear</option>
                                  <option value="Electronic">Electronic</option>
                                  <option value="Book">Book</option>
                    </select>
                </div>
            </div>
             <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price:</strong>
                    <input type="number" min="0" name="price" id="price" value="{{ $product->price }}" class="form-control" placeholder="Price">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Image:</strong>
                    <input type="file" name="image" id="image" value="{{ $product->image }}" class="form-control my-1" placeholder="image">
                    <img src="/images/{{ $product->image }}" width="200px">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="button" class="btn btn-primary" onclick="event.preventDefault(); update({{ $product->id }})">Submit</button>
            </div>
        </div>
     
    </form>

    <script>
        function update(productId) {
            console.log(productId);
            const name = document.getElementById('name').value;
            const category = document.getElementById('category').value;
            const price = document.getElementById('price').value;
            const image = document.getElementById('image').value;
            const product = {
                name,
                category,
                price,
                image
            }

            //console.log(product);
            updateProductApi(product, productId)
            .then((data) => {
                console.log('Product updated successfully');
                 window.location.href = '/products';
            })
            .catch((error) => {
                console.log(error);
                alert('Failed to update product');
            });
        }
    </script>

@endsection