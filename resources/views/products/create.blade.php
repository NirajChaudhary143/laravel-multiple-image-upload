<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Multiple Image Upload</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">
    <meta name="_token" content="{{csrf_token()}}">
</head>
<body>
<div class="bg-primary">
        <div class="container py-3">
            <h1 class="text-white">Laravel 10 Multiple Image Upload</h1>
        </div>
    </div>
    <div class="py-5">
        <div class="container">
            <form action="" name="productForm" id="productForm" method="post">
                <div class="card border-0 shadow-lg">
                    <div class="card-body">
                        
                        <div class="row">
                            <h2 class="pb-3">Create Product</h2>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="text" name="name" id="name" value="" placeholder="Name" class="form-control">
                                    
                                    @error('name')<p>{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="text" name="price" id="price" value="" placeholder="Price" class="form-control">
                                    @error('price')<p>{{ $message }}</p> @enderror
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
                            
                        </div>
                        
                    </div>
                </div>

                <div class="my-3 ">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Create</button>
                </div>
            </form>
        </div>
    </div>
    
</body>
<script src="{{ asset('assets/js/jquery-3.6.4.min.js')}}"></script>
    <script src="{{ asset('assets/js/dropzone.min.js')}}"></script>
    <script>
        Dropzone.autoDiscover = false;    
  const dropzone = $("#image").dropzone({ 
			uploadprogress: function(file, progress, bytesSent) {
          $("button[type=submit]").prop('disabled',true);
      },
      url:  "{{ route('temp-images.create') }}",
      maxFiles: 10,
      paramName: 'image',
      addRemoveLinks: true,
      acceptedFiles: "image/jpeg,image/png,image/gif",
      headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      }, success: function(file, response){
        //   $("#image_id").val(response.image_id);
        var html =`<div class="col-md-3 mb-3" id="product-image-row-${response.image_id}">
                            <div class="card image-card">
                                <a href="#" onclick="" class="btn btn-danger">Delete</a>
                                <img src="${response.imagePath}" alt="" class="w-100 card-img-top">
                                <div class="card-body">
                                    <input type="hidden" name="caption[]"  value="" class="form-control"/>
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
        $.ajax({
            url: "{{ route('products.store') }}",
            data: $(this).serializeArray(),
            method: 'post',
            dataType: 'json',
            headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
      },
            success: function(response){

            }
        });
  });


    </script>
</html>