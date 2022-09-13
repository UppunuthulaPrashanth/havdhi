@extends('cityadmin.layout.app')

@section('content')

  <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
              <a class="btn btn-success" href="{{route('adminScratchEarnAdd')}}">Add</a>
              <br><br>
              <h4 class="card-title">Scratch & Earn</h4>
              <div class="row">
                <div class="col-12 table-responsive">
                    <table id="datatableDefault" class="table text-nowrap w-100 table-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th> Names </th>
                        <th> Image </th>
                        <th> Offers </th>
                        <th> Min Cart Value </th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if(count($adminScratchEarn)>0)
                        @php $i=1; @endphp
                        @foreach($adminScratchEarn as $adminScratchEarns)
                          <tr>
                            <td>{{$i}}</td>
                            <td>{{$adminScratchEarns->scratch_card_name}}</td>
                            <td>
                              <img src="{{url($adminScratchEarns->scratch_card_image)}}" style="width:50px; height:50px; border-radius:50%;background-color:#000">
                            </td>
                            @php
                              $offer = json_decode($adminScratchEarns->scratch_card_rewards);
                            @endphp
                           
                              <td><i class="fa fa-inr"></i>{{$offer->min}} - <i class="fa fa-inr"></i>{{$offer->max}}</td>
                           <td>{{$adminScratchEarns->min_cart_value}}</td>
                            <td>
                           
                              <a href="{{route('adminScratchEarnEdit', [$adminScratchEarns->id])}}" class="btn btn-primary">Edit</a>
                             
                              <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal-{{$adminScratchEarns->id}}">Delete</button>
                      
                            </td>
                          </tr>
                        @php $i++; @endphp
                        @endforeach
                      @else
                        <tr>
                          <td>No data found</td>
                        </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

@foreach($adminScratchEarn as $adminScratchEarns)
<!-- Modal starts -->
<div class="modal fade" id="deleteModal-{{$adminScratchEarns->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-2" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel-2">Delete Scratch Card</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are u sure</p>
      </div>
      <div class="modal-footer">
        <a href="{{route('adminScratchEarnDelete', [$adminScratchEarns->id])}}" class="btn btn-success">Confirm</a>
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Ends -->
@endforeach

@endsection