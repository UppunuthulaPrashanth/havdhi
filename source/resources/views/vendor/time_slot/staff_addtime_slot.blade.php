@extends('vendor.layout.app')

@section ('content')
<div class="content-wrapper">
          <div class="row">
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Time Slot For Services</h4>
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
                  <form class="forms-sample" action="{{route('staff_addnewtimeslot')}}" method="post">
                      {{csrf_field()}}
                    <div class="form-group">
                      <label for="exampleInputName1">Open Time</label>
                      <input type="time" class="form-control" name="open_hour" >
                    </div>
                    
                    <div class="form-group">
                    <label for="exampleInputName1">Close Time</label>
                      <input type="time" class="form-control" name="close_hour" >

                    </div>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
            
                     <a href="{{route('staff_timeslot')}}" class="btn btn-light">Cancel</a>
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