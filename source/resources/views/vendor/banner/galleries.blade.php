@extends('vendor.layout.app')

@section ('content')
<div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Galleries</h4>
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
                  <form class="forms-sample" action="{{route('vendorgalleries')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}

                    <div class="form-group">
						<label>Galleries Image</label>  
						<div class="input-group col-xs-12">
						  <input type="file" name="galleries_image[]" class="file-upload-default" accept="image/*" multiple required>                        
						</div>
                    </div>

                    <button type="submit" class="btn btn-success mr-2">Submit</button>

                  </form>
				  <br/>
				  <table id="datatableDefault" class="table text-nowrap w-100 table-striped">
					<thead>
						<tr>
							<th>SN#</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($galleries as $gallery)
						<tr>
							<td>{{$gallery->id}}</td>
							<td><a href="{{asset($gallery->image)}}"><img src="{{asset($gallery->image)}}" style="width:100px;"></a></td>
							<td><a class="btn btn-success" onClick="return confirm('Are you Sure?');" href="{{route('vendorgalleries',['gallery_id'=>$gallery->id])}}">Delete</a></td>
						</tr>
						@endforeach
					</tbody>
				  </table>
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