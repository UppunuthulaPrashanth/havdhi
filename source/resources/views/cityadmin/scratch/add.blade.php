@extends('cityadmin.layout.app')

@section('content')

        <div class="content-wrapper">
          <div class="row profile-page">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="profile-body pt-0 pt-sm-4">
                    <ul class="nav tab-switch " role="tablist ">
                       <div class="card-header card-header-primary">
                  <h4 class="card-title">Add Scratch & Earn</h4>
                </div>
                    </ul>
                    <div class="row ">
                  
                      <div class="col-12 col-md-12">
                        <div class="tab-content tab-body " id="profile-log-switch ">
                          <div class="card">
                            <div class="card-body">
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
                              <!-- <h4 class="card-title">Change Password</h4> -->
                              <form class="forms-sample" action="{{route('adminScratchEarnAddNew')}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}

                                <div class="for-reward">
                                  <div class="form-group">
                                    <label for="min_amount">min amount :</label>
                                    <input type="text" class="form-control" id="min_amount" name="min_amount" placeholder="min amount" value="{{old('min_amount')}}">
                                  </div>

                                  <div class="form-group">
                                    <label for="max_amount">max amount :</label>
                                    <input type="text" class="form-control" id="max_amount" name="max_amount" placeholder="max amount" value="{{old('max_amount')}}">
                                  </div>
                                </div>

                               
                                <div class="form-group">
                                  <label for="scratch_card_name">scratch card name :</label>
                                  <input type="text" class="form-control" id="scratch_card_name" name="scratch_card_name" placeholder="scratch card name" value="{{old('scratch_card_name')}}">
                                </div>
                                 <div class="form-group">
                                  <label for="scratch_card_name">Minimum Cart Value :</label>
                                  <input type="text" class="form-control" id="cart_value" name="cart_value" placeholder="Minimum Cart Value" value="{{old('cart_value')}}">
                                </div>

                                <div class="form-group">
                                  <label>scratch card image :</label>
                                  <input type="file" name="scratch_card_image" class="file-upload-default form-control">
                                  
                                </div>

                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <a href="{{route('adminScratchEarn')}}" class="btn btn-light">back</a>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-2 col-md-2"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

@endsection
