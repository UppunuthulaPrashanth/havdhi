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
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add service</h4>
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
                  <form class="forms-sample" action="{{route('vendoraddnewservice')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    
                    <div class="form-group">
                      <label for="exampleInputName1">Service Name<sup>*</sup></label>
                      <input type="text" class="typeahead form-control" id="exampleInputName1" name="product_name" placeholder="Enter Service name" required>
                    </div>
                     <div class="form-group">
                      <label>Service Image<sup>*</sup></label>  
                      
                      <div class="input-group col-xs-12">
                      <input type="file" name="product_image" class="file-upload-default" accept="image/*" required>                        
                        </div>
                      </div>

                    <button type="button" class="onsubmit btn btn-success mr-2">Submit</button>
           
                     <a href="{{route('vendorservice')}}" class="btn btn-light">Back</a>
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
        tabsize: 2,
        height: 100
    });

</script>
@endsection
