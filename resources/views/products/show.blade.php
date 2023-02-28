@extends('products.layout')  
@section('content')
    
<div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Details
                            <a href="{{ route('products.index') }}" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">        
                    <div class="mb-3">
                            <label>Name</label>
                            <p class="form-control">
                               {{$product->name}}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label>Category</label>
                            <p class="form-control">
                               {{$product->category}}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label>Price</label>
                            <p class="form-control">
                                {{$product->price}}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label>Image</label>
                            <p class="form-control">
                                <img src="/images/{{ $product->image }}" width="175px"
                                    alt="{{$product->name}}">
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>

@endsection