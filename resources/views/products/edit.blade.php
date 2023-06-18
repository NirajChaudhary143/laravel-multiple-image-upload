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
    <style>
        .image-card{
            position: relative;
        }
        .image-card .btn-danger{
            position: absolute;
            right: 20px;
            top: 20px;
        }
    </style>
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

           <form action="" name="productForm" id="productForm" method="post">
                <div class="card border-0 shadow-lg">
                    <div class="card-body">
                        
                        <div class="row">
                            <h2 class="pb-3">Edit Product</h2>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input value="{{ $product->name }}" type="text" name="name" id="name" value="" placeholder="Name" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input value="{{ $product->price }}" type="text" name="price" id="price" value="" placeholder="Price" class="form-control">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h2 class="pb-3 mt-3">Upload Image</h2>
                                <div class="mb-3">
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">    
                                            <br>Drop files here or click to upload.<br><br>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="image-wrapper">
                            @if($productImages->isNotEmpty())
                                @foreach ($productImages as $productImage)

                                <div class="col-md-3 mb-3" id="product-image-row-{{ $productImage->id }}">
                                    <div class="card image-card">
                                        <a href="#" onclick="deleteImage({{ $productImage->id }});" class="btn btn-danger">Delete</a>
                                        <img src="{{ asset('uploads/products/'.$productImage->name) }}" alt="" class="w-100 card-img-top">
                                        <div class="card-body">
                                            <input type="hidden" name="caption[]"  value="" class="form-control"/>

                                            <input type="hidden" name="image_id[]"  value="{{ $productImage->id }}" class="form-control"/>
                                            
                                        </div>
                                    </div>
                                </div>
                                    
                                @endforeach
                            @endif
                        </div>
                        
                    </div>
                </div>

                <div class="my-3 ">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Update</button>
                </div>
            </form>
        </div>
    </div>
    
</body>
<script src="{{ asset('assets/js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>

<script type="text/javascript">
     var product_id = {{ $product->id }}
    Dropzone.autoDiscover = false;    
    const dropzone = $("#image").dropzone({ 
      uploadprogress: function(file, progress, bytesSent) {
          $("button[type=submit]").prop('disabled',true);
      },
      url:  "{{ route('products.images.store')}}",
      params: {product_id:product_id},
      maxFiles: 10,
      paramName: 'image',
      addRemoveLinks: true,
      acceptedFiles: "image/jpeg,image/png,image/gif",
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }, success: function(file, response){
            var html = `<div class="col-md-3 mb-3" id="product-image-row-${response.image_id}">
                            <div class="card image-card">
                                <a href="#" onclick="deleteImage(${response.image_id});" class="btn btn-danger">Delete</a>
                                <img src="${response.imagePath}" alt="" class="w-100 card-img-top">
                                <div class="card-body">
                                    <input type="text" name="caption[]"  value="" class="form-control"/>
                                    <input type="hidden" name="image_id[]" value="${response.image_id}"/>
                                </div>
                            </div>
                        </div>`;
            $("#image-wrapper").append(html);
            $("button[type=submit]").prop('disabled',false);
          this.removeFile(file);            
      }
  });

  $("#productForm").submit(function(event){
    event.preventDefault();
    $("button[type=submit]").prop('disabled',true);
    $.ajax({
        url: "{{ route('products.update',$product->id) }}",
        data: $(this).serializeArray(),
        method: 'post',
        dataType:'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(response){
            
        }
    });
  });


  
  

  

</script>
</html>