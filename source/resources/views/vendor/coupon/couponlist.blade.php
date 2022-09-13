@extends('vendor.layout.app')
 
@section ('content')

 <style>
     input[type="file"] {
    background-color:transparent;
    padding:0px;
}

 </style>


<!-- Begin Page Content -->
<div class="container-fluid">
 

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Coupon List</h6>
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
            <th>Coupon Name</th>
               @foreach($lang as $langs)
            <th>{{$langs->lang_name}} Coupon Name</th>
            @endforeach
            <th>Start Date</th>
            <th>End Date</th>
            <th>User Restriction</th>
            <th>Cart Value</th>
            </tr>
          </thead>
    
          <tbody>
          @if(count($coupon)>0)
                          @php $i=1; @endphp
                          @foreach($coupon as $coupons)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$coupons->coupon_name}}</td>
                             @foreach($lang as $langs)
                              <?php $tex = $langs->lang_prefix.'_coupon_name' ?>
                            <td>{{$coupons->$tex}}</td>
                            @endforeach
                            <td>{{$coupons->start_date}}</td>
                            <td>{{$coupons->end_date}}</td>
                            <td>{{$coupons->uses_restriction}}</td>
                            <td>{{$coupons->cart_value}}</td>
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
                {!! $coupon->links("pagination::bootstrap-4") !!}

      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
</div>
</div>
  
@endsection