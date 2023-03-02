@extends('products.layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left text-center my-3">
            <h2>Add New Product</h2>
        </div>
        <div class="pull-right my-2">
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
     
<form method="POST" enctype="multipart/form-data">
    @csrf
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" id="name" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 my-2">
            <div class="form-group">
                <strong>Category:</strong>
                <select class="form-select" required name="category" id="category">
        <option value="" disabled selected>Select Category</option>
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
                <input type="number" min="0" name="price" id="price" class="form-control" placeholder="Price">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 my-2">
            <div class="form-group">
                <strong>Image:</strong>
                <input type="file" name="image" id="image" class="form-control" placeholder="image">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center my-3">
                <button type="button" class="btn btn-primary" onclick="event.preventDefault(); create()">Submit</button>
        </div>
    </div> 
</form>
<script>

function create() {
  const name = document.getElementById("name").value;
  const category = document.getElementById("category").value;
  const price = document.getElementById("price").value;
  const image = document.getElementById("image").files[0];
  const product = { name, category, price, image };
  
  createProductApi(product)
    .then((data) => {
      console.log("Product created successfully");
      window.location.href = "/products";
    })
    .catch((error) => {
      console.error(error);
      alert("Failed to create product");
    });
}

</script>

@endsection