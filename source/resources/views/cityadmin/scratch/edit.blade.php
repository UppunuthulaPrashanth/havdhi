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
                  <h4 class="card-title">Edit Scratch & Earn</h4>
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
                              <form class="forms-sample" action="{{route('adminScratchEarnUpdate', [$adminScratchEarnEdit->id])}}" method="post" enctype="multipart/form-data">
                                {{csrf_field()}}



                                @php
                                  $offer = json_decode($adminScratchEarnEdit->scratch_card_rewards);
                                @endphp
                                <div class="for-reward">
                                  <div class="form-group">
                                    <label for="min_amount">min amount:</label>
                                    <input type="text" class="form-control" id="min_amount" name="min_amount" placeholder="min amount" value="{{$offer->min}}">
                                  </div>

                                  <div class="form-group">
                                    <label for="max_amount">max amount:</label>
                                    <input type="text" class="form-control" id="max_amount" name="max_amount" placeholder="max amount" value="{{$offer->max}}">
                                  </div>
                                </div>



                                <div class="form-group">
                                  <label for="scratch_card_name">scratch card name :</label>
                                  <input type="text" class="form-control" id="scratch_card_name" name="scratch_card_name" placeholder="scratch card name" value="{{$adminScratchEarnEdit->scratch_card_name}}">
                                </div>
                                 <div class="form-group">
                                  <label for="scratch_card_name">Minimum Cart Value :</label>
                                  <input type="text" class="form-control" id="cart_value" name="cart_value" placeholder="Minimum Cart Value" value="{{$adminScratchEarnEdit->min_cart_value}}">
                                </div>
                                <div class="form-group">
                                  <label>scratch card image :</label>
                                  <input type="file" name="scratch_card_image" class="file-upload-default">

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
