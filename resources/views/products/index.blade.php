@extends('products.layout')
     
@section('content')
@if ($message = Session::get('created'))
        <div class="alert alert-success my-2">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 margin-tb py-4">
            <div class="pull-right">
               
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
              
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
     
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Handle</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Image</th>
            <th width="280px">RUD Operation</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $product->handle }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category }}</td>
            <td>{{ $product->price }}</td>
            <td><img src="/images/{{ $product->image }}" width="100px"></td>
            <td>
                    <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a> 
                    <a class="btn btn-primary" href="{{ route('products.update',$product->id) }}">Edit</a>
                    <button class="btn btn-danger" onclick="deleteProduct({{ $product->id }})">Delete</button>
            </td>
        </tr>
        @endforeach
    </table>
    
    {!! $products->links('pagination::bootstrap-5') !!}

    <script src="{{ asset('js/api.js') }}"></script>
<script>

async function deleteProduct(productId) {
  try {
    const result = confirm("Are you sure you want to delete this product?");
    if (result) {
      await deleteProduct(productId);
      window.location.reload();
    }
  } catch (error) {
    console.error(error);
    alert("Failed to delete product. Please try again later.");
  }
}
</script>
        
@endsection