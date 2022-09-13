@extends('cityadmin.layout.app')

@section ('content')
<div class="content-wrapper">
          <div class="row">
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update App Users</h4>
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
                  <form class="forms-sample" action="{{route('updateuser',$user->id)}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="form-group">
                      <label for="exampleInputName1">User Status</label>
                    <select class="form-control form-control-sm"  name="active">
		          	    <option value="0" @if(0 == $user->active) selected @endif>
		          	        pending
		          	    </option>
                    <option value="1" @if(1 == $user->active) selected @endif>
		          	        confirmed
		          	    </option>
                    <option value="2" @if(2 == $user->active) selected @endif>
		          	        Rejected
		          	    </option>                      
                      
                    </select>
                    </div>
                  
                    <div class="form-group">
                      <label for="exampleInputName1">User Description</label>
                      <input type="text" class="form-control" id="exampleInputName1" value="{{$user->description}}" name="description" placeholder="Enter description">
                    </div>
                     
                 
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
               
                     <a href="{{route('allusersreview')}}" class="btn btn-light">Cancel</a>
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