@extends('cityadmin.layout.app')

@section ('content')
<style>
input.form-control.file-upload-info {
    padding: 3px;
    border: 0px;
}
</style>

        <div class="content-wrapper">
          <div class="row">
		  <div class="col-md-2">
		  </div>
            
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add lang</h4>
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
                  <form class="forms-sample" action="{{route('lang_add')}}" method="post" enctype="multipart/form-data">
                      {{csrf_field()}}
                    <div class="form-group">
                      <label for="exampleInputName1">Language</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="lang_name" placeholder="Enter Language Name" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputName1">Language prefix</label>
                     <input type="text" class="form-control" id="exampleInputName1" name="lang_prefix" placeholder="Enter Language prefix like in for hindi, ar for arabic etc" required>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <!--
                    <button class="btn btn-light">Cancel</button>
                    -->
                     <a href="{{route('lang_list')}}" class="btn btn-light">Cancel</a>
                  </form>
                </div>
              </div>
            </div>
             <div class="col-md-2">
		  </div>
     
          </div>
        </div>
        </div>
 @endsection