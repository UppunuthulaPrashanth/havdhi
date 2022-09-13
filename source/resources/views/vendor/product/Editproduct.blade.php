@extends('vendor.layout.app')

@section ('content')
<div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Service</h4>
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
                  <form class="forms-sample" action="{{route('vendorupdateservice',$product->service_id)}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                  
                    <div class="form-group">
                      <label for="exampleInputName1">Service Name</label>
                      <input type="text" class="form-control" id="exampleInputName1" value="{{$product->service_name}}" name="product_name" placeholder="Enter Service Name">
                    </div>
                        @foreach($lang as $langs)
                              <?php $tex = $langs->lang_prefix.'_service_name' ?>
                     <div class="form-group">
                      <label for="exampleInputName1">Service Name in {{$langs->lang_name}}<sup>*</sup></label>
                      <input type="text" class="typeahead form-control" id="exampleInputName1" name="{{$tex}}" value="{{$product->$tex}}" required>
                    </div>
                    @endforeach
                     <div class="form-group">
                      <label>Service image</label>
                      
                      <input type="hidden" name="old_product_image" value="{{$product->service_image}}" class="file-upload-default">
                      <div class="input-group col-xs-12">
                      <input type="file" name="product_image" class="file-upload-default">
                      </div>
                    </div>
                    
              
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
               
                     <a href="{{route('vendorservice')}}" class="btn btn-light">Cancel</a>
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
<script type="text/javascript">
        	$(document).ready(function(){
        	
                $(".des_price").hide();
                
        		$(".img").on('change', function(){
        	        $(".des_price").show();
        			
        	});
        	});
</script>
@endsection