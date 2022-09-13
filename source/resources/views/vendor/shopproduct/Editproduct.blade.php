@extends('vendor.layout.app')

<!-- include summernote css/js -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<style>
sup {
    color:red;
    position: initial;
    font-size: 111%;
}
.note-editable p{
	margin:0px;
}
</style>
@section ('content')
<div class="content-wrapper">
          <div class="row">

            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Product</h4>
                   @if (count($errors) > 0)
                      @if($errors->any())
                        <div class="alert alert-primary" role="alert">
                          {{$errors->first()}}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                      @endif
                  @endif
                  <form class="forms-sample" action="{{route('shop_update_product',$product->id)}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                      
					  
                    <div class="form-group">
                      <label for="exampleInputName1">Product Name<sup>*</sup></label>
                      <input type="text" class="typeahead form-control" id="exampleInputName1" name="product_name" value="{{$product->product_name}}" placeholder="Enter Product name" required>
                    </div>
                      @foreach($lang as $langs)
                              <?php $tex = $langs->lang_prefix.'_product_name' ?>
                     <div class="form-group">
                      <label for="exampleInputName1">Product Name in {{$langs->lang_name}}<sup>*</sup></label>
                      <input type="text" class="typeahead form-control" id="exampleInputName1" name="{{$tex}}" value="{{$product->$tex}}" required>
                    </div>
                    @endforeach
                     <div class="form-group row">
                      
						<div class="input-group col-md-4">
							<label style="display:block;width:100%;">Product Image<sup>*</sup></label>  
							<input type="file" name="product_image"  class="file-upload-default" accept="image/*">                        
						</div>
						<div class="input-group col-md-8">
							<a href="{{asset($product->product_image)}}" target="_blank"><img src="{{asset($product->product_image)}}" style="width:50px;" /></a>
						</div>
                      </div>
                    
                      <div class="form-group">
                      <label for="exampleInputName1">Quantity<sup>*</sup></label>
                      <input type="text" class="form-control" id="exampleInputName1" name="quantity" value="{{$product->quantity}}" placeholder="Enter Quantity" required>
                    </div>
                   
					<div class="form-group">
                      <label for="exampleInputName1">Price<sup>*</sup></label>
                      <input type="text" class="form-control" id="exampleInputName1" name="price" value="{{$product->price}}" placeholder="Enter price" required>
                    </div>  
                    <div class="form-group">
                      <label for="exampleInputName1">Description<sup>*</sup></label>
					  <textarea id="product_description" name="product_description" style="display:nones;" required>{{$product->description}}</textarea>
                    </div>
                    
                     @foreach($lang as $langs)
                              <?php $tex2 = $langs->lang_prefix.'_description' ?>
                     <div class="form-group">
                      <label for="exampleInputName1">Product Description in {{$langs->lang_name}}<sup>*</sup></label>
                      <textarea id="product_description{{$tex2}}" name="{{$tex2}}" style="display:nones;" required>{{$product->$tex2}}</textarea>
                    
                    </div>
                    <script>
                    	$('#product_description{{$tex2}}).summernote({
                        tabsize: 2,
                        height: 100
                    });
                    </script>

                    @endforeach
                    <button type="button" class="onsubmit btn btn-success mr-2">Submit</button>
           
                     <a href="{{route('shopproduct')}}" class="btn btn-light">Back</a>
                  </form>
                </div>
              </div>
            </div>
             <div class="col-md-2">
		  </div>
     
          </div>
        </div>
       </div> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>



<script type="text/javascript">

	var path = "{{ route('search_services') }}";
    $('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });

	$('.onsubmit').click(function() {
	  $('#product_description').val($( ".note-editable" ).html());
	  $( ".forms-sample" ).submit();
	});

	$('#product_description').summernote({
        tabsize: 8,
        height: 100
    });
    
</script>

  
                     @foreach($lang as $langs)
                              <?php $tex2 = $langs->lang_prefix.'_description' ?>
                     
                    <script>
                       	$('.onsubmit').click(function() {
                    	  $('#product_description{{$tex2}}').val($( ".note-editable" ).html());
                    	  $( ".forms-sample" ).submit();
                    	});
                    
                    	$('#product_description{{$tex2}}').summernote({
                        tabsize: 2,
                        height: 100
                    });
                    </script>

                    @endforeach
@endsection
