@extends('vendor.layout.app')

@section ('content')


<!-- Begin Page Content -->
<div class="container-fluid">
 

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
        @if($status==0)
          <h6 class="m-0 font-weight-bold text-primary">Pending Orders List</h6>
        @elseif($status==1)
          <h6 class="m-0 font-weight-bold text-primary">Confirmed Orders List</h6>
        @elseif($status==2)
          <h6 class="m-0 font-weight-bold text-primary">Cancelled Orders List</h6>
        @elseif($status==3)
          <h6 class="m-0 font-weight-bold text-primary">Missing Orders</h6>
        @else
          <h6 class="m-0 font-weight-bold text-primary">NA</h6>
        @endif
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
    </div>
    <div class="card-body">
      <div class="table-responsive">
         <table id="datatableDefault" class="table text-nowrap w-100 table-striped">
          <thead>
            <tr>
                <th>S.No</th>
                <th>Vendor Name</th>
                <th>User Name</th>
                <th>Staff Name</th>
                <th>Total Price</th>
                <th>Service Date</th>
                <th>Service Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
          </thead>
         
          <tbody>
          @if(count($orders)>0)
                          @php $i=1; @endphp
                          @foreach($orders as $order)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$order->vendor->vendor_name}}</td>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->staff->staff_name}}</td>
                            <td>{{$order->total_price}}</td>
                            <td>{{date('d-M-Y',strtotime($order->service_date))}}</td>
                            <td>{{$order->service_time}}</td>
                            <td>{{$order->statustext}}</td>
                            <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$order->id}}"> Order Details </button>
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
<!-- /.container-fluid -->
</div>
</div>
   
@foreach($orders as $order)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order Details with Cart ID #{{$order->cart_id}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <table class="table">
          <thead>
            <tr class="thead-dark">
              <th colspan="7">Order Details</th>
            </tr>
            <tr class="thead-light">
              <th scope="col">Vendor Name</th>
              <th scope="col">User Name</th>
              <th scope="col">Staff Name</th>
              <th scope="col">Total Price</th>
              <th scope="col">Service Date</th>
              <th scope="col">Service Time</th>
              <th scope="col">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td>{{ucwords($order->vendor->vendor_name)}}</td>
                <td>{{ucwords($order->user->name)}}</td>
                <td>{{ucwords($order->staff->staff_name)}}</td>
                <td>{{$order->total_price}}</td>
                <td>{{date('d-M-Y',strtotime($order->service_date))}}</td>
                <td>{{$order->service_time}}</td>
                <td>{{$order->statustext}}</td>
            </tr>
          </tbody>
        </table>

        <table class="table">
          <thead>
            <tr class="thead-dark">
              <th colspan="5">Order Items Details</th>
            </tr>
            <tr class="thead-light">
              <th scope="col">#</th>
              <th scope="col">Service Name</th>
              <th scope="col">Service Image</th>
              <th scope="col">Variant Name</th>
              <th scope="col">Variant Price</th>
            </tr>
          </thead>
          <tbody>
              @foreach($order->items as $index=>$item)
            <tr>
                <td>{{++$index}}</td>
                <td>{{ucwords($item->service_name)}}</td>
                <td><a href="{{asset($item->service->service_image)}}" target="_blank"><img src="{{asset($item->service->service_image)}}" style="width:50px;" /></a></td>
                <td>{{ucwords($item->varient)}}</td>
                <td>{{$item->price}}</td>
            </tr>
              @endforeach
          </tbody>
        </table>

      </div>
      <div class="modal-footer" style="display:block;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="float:right;">Close</button>
        @if($order->status==0 || $order->status==1)
        <a onClick="return confirm('Are You Sure? You Want to Accept This Order');" href="{{url('vendors/orders_accepted')}}/{{$order->id}}" class="btn btn-warning" > Comfirm Order</a>
        <a onClick="return confirm('Are You Sure? You Want to Cancel This Order');" href="{{url('vendors/orders_cancelled')}}/{{$order->id}}" class="btn btn-danger" > Cancel</a>
        @endif
        @if($order->status==6)
        <a onClick="return confirm('Are You Sure? You Want to Complete This Order');" href="{{url('vendors/orders_complete')}}/{{$order->id}}" class="btn btn-warning" > Complete Order</a>
        <a onClick="return confirm('Are You Sure? You Want to Cancel This Order');" href="{{url('vendors/orders_cancelled')}}/{{$order->id}}" class="btn btn-danger" > Cancel</a>
        @endif
      </div>
    </div>
  </div>
</div>

@endforeach

   
@endsection