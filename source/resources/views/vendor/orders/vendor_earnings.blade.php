@extends('vendor.layout.app')

@section ('content')



        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">



          <!-- BEGIN row -->
            <div class="row">

                <!-- BEGIN col-6 -->
                <div class="col-xl-12">
                    <!-- BEGIN row -->
                    <div class="row">
                        <!-- BEGIN col-12 -->
                        
                        
                        <div class="col-sm-4">
                            <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-orange" style="min-height: 100px;">
                                <!-- BEGIN card-body -->
                                <div class="card-body position-relative">
                                    <h5 class="text-white-transparent-8 mb-3 fs-16px">Total Earnings</h5>
                                    <h3 class="text-white mt-n1"> </h3>
                                    <div class="progress bg-black-transparent-5 mb-2" style="height: 6px">
                                        <div class="progrss-bar progress-bar-striped bg-white" style="width: 100%"></div>
                                    </div>
                                    <div class="text-white-transparent-8 mb-4"></i> here is the total<br /> {{$total_price}}</div>
                                    
                                </div>
                                <!-- BEGIN card-body -->
                            </div>
                        </div>

                        
                        <div class="col-sm-4">
                            <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-teal" style="min-height: 100px;">

                                <!-- BEGIN card-body -->
                                <div class="card-body position-relative"  data-toggle="modal" @if($share_given_amount > 0 ) data-target="#exampleModal" @endif>
                                    <h5 class="text-white-transparent-8 mb-3 fs-16px">Total Vendor Share given by Admin</h5>
                                    <h3 class="text-white mt-n1"></h3>
                                    <div class="progress bg-black-transparent-5 mb-2" style="height: 6px"> 
                                        <div class="progrss-bar progress-bar-striped bg-white" style="width: 100%"></div>
                                    </div>
                                    <div class="text-white-transparent-8 mb-4"></i>here is the total<br /> {{$share_given_amount}}</div>
                                    
                                </div>
                                <!-- END card-body -->
                            </div>
                        </div>

                        
                        <div class="col-sm-4">
                            <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-teal" style="min-height: 100px;">

                                <!-- BEGIN card-body -->
                                <div class="card-body position-relative"  data-toggle="modal" @if($share_given_pending_amount > 0 ) data-target="#exampleModal3" @endif>
                                    <h5 class="text-white-transparent-8 mb-3 fs-16px">Total Vendor Share pending at Admin</h5>
                                    <h3 class="text-white mt-n1"></h3>
                                    <div class="progress bg-black-transparent-5 mb-2" style="height: 6px"> 
                                        <div class="progrss-bar progress-bar-striped bg-white" style="width: 100%"></div>
                                    </div>
                                    <div class="text-white-transparent-8 mb-4"></i>here is the total<br /> {{$share_given_pending_amount}}</div>
                                    
                                </div>
                                <!-- END card-body -->
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-sm-4">
                            <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-pink" style="min-height: 100px;">

                                <!-- BEGIN card-body -->
                                <div class="card-body position-relative"  data-toggle="modal" @if($share_sent_amount > 0 ) data-target="#exampleModal2" @endif>
                                    <h5 class="text-white-transparent-8 mb-3 fs-16px">Total Admin Share sent by Vendor</h5>
                                    <h3 class="text-white mt-n1"></h3>
                                    <div class="progress bg-black-transparent-5 mb-2" style="height: 6px">
                                        <div class="progrss-bar progress-bar-striped bg-white" style="width: 100%"></div>
                                    </div>
                                    <div class="text-white-transparent-8 mb-4"></i> here is the total<br />  {{$share_sent_amount}}</div>
                                   
                                </div>
                                <!-- END card-body -->
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-pink" style="min-height: 100px;">

                                <!-- BEGIN card-body -->
                                <div class="card-body position-relative"  data-toggle="modal" @if($share_sent_pending_amount > 0 ) data-target="#exampleModal4" @endif>
                                    <h5 class="text-white-transparent-8 mb-3 fs-16px">Total Admin Share pending at Vendor</h5>
                                    <h3 class="text-white mt-n1"></h3>
                                    <div class="progress bg-black-transparent-5 mb-2" style="height: 6px">
                                        <div class="progrss-bar progress-bar-striped bg-white" style="width: 100%"></div>
                                    </div>
                                    <div class="text-white-transparent-8 mb-4"></i> here is the total<br />  {{$share_sent_pending_amount}}</div>
                                   
                                </div>
                                <!-- END card-body -->
                            </div>
                        </div>


                    </div>
                    <!-- END row -->
                </div>
                <!-- END col-6 -->
            </div>
            <!-- END row -->
            
           
        </div>
        
    
    <!-- Modal for Total Vendor Share given by Admin -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Total Vendor Share given by Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">SN#</th>
                      <th scope="col">Cart ID</th>
                      <th scope="col">Total Price</th>
                      <th scope="col">Payment Method</th>
                      <th scope="col">Service Date</th>
                      <th scope="col">Vendor Share</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($share_sent as $index_share_sent => $share_sent_row)
                    <tr>
                      <th scope="row">{{++$index_share_sent}}</th>
                      <td>{{$share_sent_row->cart_id}}</td>
                      <td>Rs.{{$share_sent_row->total_price}}</td>
                      <td>{{$share_sent_row->payment_method}}</td>
                      <td>{{$share_sent_row->service_date}}</td>
                      <td>Rs.{{ ( ( $share_sent_row->total_price * $admin_share ) / 100) }}</td>
                    </tr>
                      @endforeach
                  </tbody>
                </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    
    
    <!-- Modal for Total Admin Share sent by Vendor -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Total Admin Share sent by Vendor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">SN#</th>
                      <th scope="col">Cart ID</th>
                      <th scope="col">Total Price</th>
                      <th scope="col">Payment Method</th>
                      <th scope="col">Service Date</th>
                      <th scope="col">Vendor Share</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($share_given as $index_share_given => $share_given_row)
                    <tr>
                      <th scope="row">{{++$index_share_given}}</th>
                      <td>{{$share_given_row->cart_id}}</td>
                      <td>Rs.{{$share_given_row->total_price}}</td>
                      <td>{{$share_given_row->payment_method}}</td>
                      <td>{{$share_given_row->service_date}}</td>
                      <td>Rs.{{ ( ( $share_given_row->total_price * $admin_share ) / 100) }}</td>
                    </tr>
                      @endforeach
                  </tbody>
                </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    

    <!-- Modal for Total Vendor Share pending at Admin -->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Total Vendor Share pending at Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">SN#</th>
                      <th scope="col">Cart ID</th>
                      <th scope="col">Total Price</th>
                      <th scope="col">Payment Method</th>
                      <th scope="col">Service Date</th>
                      <th scope="col">Vendor Share</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($share_given_pending as $index_share_given_pending => $share_given_pending_row)
                    <tr>
                      <th scope="row">{{++$index_share_given_pending}}</th>
                      <td>{{$share_given_pending_row->cart_id}}</td>
                      <td>Rs.{{$share_given_pending_row->total_price}}</td>
                      <td>{{$share_given_pending_row->payment_method}}</td>
                      <td>{{$share_given_pending_row->service_date}}</td>
                      <td>Rs.{{ ( ( $share_given_pending_row->total_price * $admin_share ) / 100) }}</td>
                    </tr>
                      @endforeach
                  </tbody>
                  <tfooter class="thead-dark">
                    <tr>
                      <th scope="col"></th>
                      <th scope="col"></th>
                      <th scope="col"></th>
                      <th scope="col"></th>
                      <th scope="col">Total</th>
                      <th scope="col">Rs.{{$share_given_pending_amount}}</th>
                    </tr>
                  </tfooter>
                </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       <!-- <a href="{{url('vendors/request_to_admin')}}" class="btn btn-success" >Request to Admin</a>-->
      </div>
    </div>
  </div>
</div>
    


    <!-- Modal for Total Admin Share pending at Vendor -->
<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Total Admin Share pending at Vendor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">SN#</th>
                      <th scope="col">Cart ID</th>
                      <th scope="col">Total Price</th>
                      <th scope="col">Payment Method</th>
                      <th scope="col">Service Date</th>
                      <th scope="col">Vendor Share</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($share_sent_pending as $index_share_sent_pending => $share_sent_pending_row)
                    <tr>
                      <th scope="row">{{++$index_share_sent_pending}}</th>
                      <td>{{$share_sent_pending_row->cart_id}}</td>
                      <td>Rs.{{$share_sent_pending_row->total_price}}</td>
                      <td>{{$share_sent_pending_row->payment_method}}</td>
                      <td>{{$share_sent_pending_row->service_date}}</td>
                      <td>Rs.{{ ( ( $share_sent_pending_row->total_price * $admin_share ) / 100) }}</td>
                    </tr>
                      @endforeach
                  </tbody>
                  <tfooter class="thead-dark">
                    <tr>
                      <th scope="col"></th>
                      <th scope="col"></th>
                      <th scope="col"></th>
                      <th scope="col"></th>
                      <th scope="col">Total</th>
                      <th scope="col">Rs.{{$share_sent_pending_amount}}</th>
                    </tr>
                  </tfooter>
                </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="{{url('vendors/paid_to_admin')}}" class="btn btn-success" >Mart as Paid to Admin</a>
      </div>
    </div>
  </div>
</div>
    

@endsection