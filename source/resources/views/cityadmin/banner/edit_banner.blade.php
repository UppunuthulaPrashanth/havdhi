@extends('cityadmin.layout.app')

@section ('content')
<div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add banner</h4>
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
                  <form class="forms-sample" action="{{route('addadminbanner')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}

                    <div class="form-group">
                      <label for="exampleInputName1">Vendor Name</label>
					  <select class="form-control" name="vendor_id" required>
						<option value="">Select Vendor Name</option>
						@foreach($vendors as $vendor)
						<option value="{{$vendor->vendor_id}}" @if($banner->vendor_id==$vendor->vendor_id) selected @endif>{{$vendor->vendor_name}}</option>
						@endforeach
					  </select>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputName1">Banner Name</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="banner_name" value="{{$banner->banner_name}}" placeholder="Enter Banner Name">
                    </div>

                    <div class="form-group row">
						<div class="input-group col-md-4">
							<label style="display:block;width:100%;">Banner Image</label>  
							<input type="file" name="banner_image" accept="image/*" class="file-upload-default">                        
                        </div>
						<div class="input-group col-md-8">
							<img src="{{asset($banner->banner_image)}}" style="width:100px;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mr-2">Submit</button>

                     <a href="{{route('adminbanner')}}" class="btn btn-light">Back</a>
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