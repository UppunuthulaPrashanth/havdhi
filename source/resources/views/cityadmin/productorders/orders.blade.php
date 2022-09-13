@extends('cityadmin.layout.app')

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
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Order Cart ID</th>
                <th>Order Date</th>
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
                            <td>{{$order->product_name}}</td>
                            <td>{{$order->qty}}</td>
                            <td>{{$order->price}}</td>
                            <td>{{$order->total_price}}</td>
                            <td>{{$order->order_cart_id}}</td>
                            <td>{{date('d-M-Y',strtotime($order->order_date))}}</td>
                            <td>{{$order->statustext}}</td>
                            <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$order->store_order_id}}"> Order Details </button>
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
<div class="modal fade" id="exampleModal{{$order->store_order_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order Details with Cart ID {{$order->order_cart_id}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <table class="table table-hover">
          <tbody class="">
            <tr>
              <th style="width: 200px;border: none;">Vendor Name</th>
              <td style="border: none;">{{ucwords($order->vendor->vendor_name)}}</td>
            </tr>
            <tr>
              <th scope="col">User Name	</th>
              <td>{{ucwords($order->user->name)}}</td>
            </tr>
            <tr>
              <th scope="col">Product Name	</th>
              <td>{{ucwords($order->product_name)}}</td>
            </tr>
            <tr>
              <th scope="col">Quantity	</th>
              <td>{{$order->qty}}</td>
            </tr>
            <tr>
              <th scope="col">Price	</th>
              <td>{{$order->price}}</td>
            </tr>
            <tr>
              <th scope="col">Total Price </th>
              <td>{{$order->total_price}}</td>
            </tr>
            <tr>
              <th scope="col">Order Cart ID</th>
              <td>{{$order->order_cart_id}}</td>
            </tr>
            <tr>
              <th scope="col">Order Date</th>
              <td>{{date('d-M-Y',strtotime($order->order_date))}}</td>
            </tr>
            <tr>
              <th scope="col">Status</th>
              <td>{{$order->statustext}}</td>
            </tr>
            <tr>
              <th scope="col">Product Image</th>
              <td><a href="{{asset($order->product_image)}}" target="_blank"><img src="{{asset($order->product_image)}}" style="width:100px;"></a></td>
            </tr>
          </tbody>
        </table>

      </div>
      <div class="modal-footer" style="display:block;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="float:right;">Close</button>
      </div>
    </div>
  </div>
</div>

@endforeach

   
@endsection