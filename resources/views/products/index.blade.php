@extends('products.layout')

@section('content')

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
        <tr class="product-row" data-product-id="{{ $product->id }}">
            <td>{{ ++$i }}</td>
            <td>{{ $product->handle }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category }}</td>
            <td>{{ $product->price }}</td>
            <td><img src="/images/{{ $product->image }}" width="100px"></td>
            <td>
                    <button type="button" class="btn btn-success" onclick="event.preventDefault(); showProduct({{ $product->id }})">Show</button>
                    <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                    <button type="button" class="btn btn-danger" onclick="event.preventDefault(); deleteProduct({{ $product->id }})">Delete</button>
            </td>
        </tr>
        @endforeach
    </table>
    
    {!! $products->links('pagination::bootstrap-5') !!}

    {{-- <script src="{{ asset('js/api.js') }}"></script> --}}
<script>

    const alertMessage = sessionStorage.getItem("alertMessage");
if (alertMessage) {
    const alertDiv = document.createElement("div");
    alertDiv.className = "alert alert-success my-2";
    alertDiv.innerHTML = `<p>${alertMessage}</p>`;
    document.body.appendChild(alertDiv);
    sessionStorage.removeItem("alertMessage");
}

async function showProduct(productId) {
  try {
    const product = await getProductApi(productId);
    // const row = document.querySelector(`tr[data-product-id="${productId}"]`);
    // //console.log(row);
    // if (row) {
    //   row.querySelector("td:nth-child(2)").textContent = product.handle;
    //   row.querySelector("td:nth-child(3)").textContent = product.name;
    //   row.querySelector("td:nth-child(4)").textContent = product.category;
    //   row.querySelector("td:nth-child(5)").textContent = product.price;
    //   row.querySelector("td:nth-child(6) img").src = `/images/${product.image}`;
    // }
    window.location.href = `/web/products/${productId}`;
  } catch (error) {
    console.error(error);
    alert("Failed to retrieve product. Please try again later.");
  }
}




async function deleteProduct(productId) {
  try {
    const result = confirm("Are you sure you want to delete this product?");
    if (result) {
      await deleteProductApi(productId);
      window.location.reload();
    }
  } catch (error) {
    console.error(error);
    alert("Failed to delete product. Please try again later.");
  }
}
</script>
        
@endsection