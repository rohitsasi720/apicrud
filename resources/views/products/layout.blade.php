<!DOCTYPE html>
<html>
<head>
    <title>Api Crud</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/api.js') }}"></script>
</head>
<body>
 
<nav class="navbar navbar-expand-lg bg-dark">
        <div class="container-fluid">
        <a class="navbar-brand" style="color: white; font-size: 1.6em;" href="/products">Api Crud</a>
        @auth
            <span style="color: white; font-size: 1.2em;" > Welcome {{ auth()->user()->name }} </span>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary ml-auto" style="color: white;">Log Out</button>
        </form>
@endauth
        @guest
        <div class="d-flex">
            <a href="/register" class="btn btn-primary mx-2" style="color: white;">Register</a>
            <a href="/login" class="btn btn-primary" style="color: white;">Login</a>
        </div>
        @endguest
  </div>
    </nav>    
<div class="container">
    @yield('content')
</div>
   
</body>
</html>