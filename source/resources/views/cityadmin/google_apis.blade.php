@extends('cityadmin.layout.app')

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
.hidden{
	display:none;
}
</style>
@section ('content')
<div class="content-wrapper">
          <div class="row">
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Edit Terms & Conditions</h4>
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
                  <form class="forms-sample" action="{{route('google_apis_save')}}" method="post">
                      {{csrf_field()}}
                    
					
                    <div class="form-group">
						<label class="row col-md-12">Active API <span class="text-danger">&nbsp; *</span></label>
						<div class="row col-md-12">
							<div class="form-check col-md-3">
							  <input class="form-check-input" type="radio" name="map_api_type" id="google_map" value="google_map" @if($map_settings->google_map==1) checked @endif onClick="$('.map_api_key').show();$('.mapbox_api').hide();">
							  <label class="form-check-label" for="google_map">
								Google API
							  </label>
							</div>
							<div class="form-check col-md-3">
							  <input class="form-check-input" type="radio" name="map_api_type" id="mapbox" value="mapbox" @if($map_settings->mapbox==1) checked @endif onClick="$('.map_api_key').hide();$('.mapbox_api').show();">
							  <label class="form-check-label" for="mapbox">
								Mapbox API
							  </label>
							</div>
						</div>
                    </div>
                    <div class="form-group map_api_key @if($map_settings->google_map==0) hidden @endif">
						<label class="row col-md-12">Google API Key<span class="text-danger">&nbsp; *</span></label>
						<input type="text" class="form-control" value="{{$map_api->map_api_key}}" name="map_api_key">
                    </div>
                    <div class="form-group mapbox_api @if($map_settings->mapbox==0) hidden @endif">
						<label class="row col-md-12">Mapbox API Key<span class="text-danger">&nbsp; *</span></label>
						<input type="text" class="form-control" value="{{$mapbox->mapbox_api}}" name="mapbox_api">
                    </div>
                    <button type="button" class="onsubmit btn btn-success mr-2">Save</button>

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
	  $('#termcondition').val($( ".note-editable" ).html());
	  $( ".forms-sample" ).submit();
	});

	$('#termcondition').summernote({
        tabsize: 2,
        height: 100
    });

</script>
@endsection
