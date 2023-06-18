<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Multiple Image Upload</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">
    <meta name="_token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="bg-primary">
        <div class="container py-3">
            <h1 class="text-white">Laravel 10 Multiple Image Upload</h1>
        </div>
    </div>
    <div class="py-5">
        <div class="container">
            @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            
            @if(Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
            @endif
            
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('create') }}" class="btn btn-primary">Create</a>
            </div>

            <div class="card border-0 shadow-lg ">
                <div class="card-body">
                        <h2 class="pt-2 pb-3">Products</h2>

                    <table class="table table-striped">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Edit</th>
                        </tr>
                        @if($products->isNotEmpty())
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <a href="{{ route('products.edit',$product->id) }}" class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                        
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</body>
<script src="{{ asset('assets/js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
</html>