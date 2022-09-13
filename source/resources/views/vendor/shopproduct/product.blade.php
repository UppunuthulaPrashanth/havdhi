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
      <h6 class="m-0 font-weight-bold text-primary">Show Products</h6>
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
        <a class="btn btn-success m-auto" style="float: right;" href="{{route('add_shopproduct')}}">Add Product</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
          <table id="datatableDefault" class="table text-nowrap w-100 table-striped">
          <thead>
            <tr>
				<th>Product ID</th>
				<th>Product Name</th>
				  @foreach($lang as $langs)
                  <?php $tex = $langs->lang_name.' product name' ?>
                <th>{{$tex}}</th>
                @endforeach
				<th>Product Image</th>
				<th>Action</th>
            </tr>
          </thead>
    
          <tbody>
          @if(count($product)>0)
                          @php $i=1; @endphp
                          @foreach($product as $products)
                        <tr>
                            <td>{{$products->id}}</td>
                            <td>{{$products->product_name}}</td>
                             @foreach($lang as $langs)
                              <?php $tex = $langs->lang_prefix.'_product_name' ?>
                            <td>{{$products->$tex}}</td>
                            @endforeach
                            <td align="center"><img src="{{url($products->product_image)}}" style="width: 21px;"></td>
                            <td>
                               <a href="{{route('shop_edit_product',$products->id)}}" style="width: 28px; padding-left: 6px;" class="btn btn-info"  style="width: 10px;padding-left: 9px;" style="color: #fff;"><i class="fa fa-edit" style="width: 10px;"></i></a>
							<button type="button" style="width: 28px; padding-left: 6px;" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{$products->id}}"><i class="fa fa-trash"></i></button>
              <!--<a href="{{route('varient',$products->id)}}" style="width: auto; padding: 6px;" class="btn btn-info">other variants</a>-->
							</td>
							

                        </tr>
                        @php $i++; @endphp
                        @endforeach
                      @else
                        <tr>
                          <td colspan="4">No data found</td>
                        </tr>
                      @endif
                       
          </tbody>
        </table>
                {!! $product->links("pagination::bootstrap-4") !!}
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->
</div>
</div>
@foreach($product as $products)
<!-- Modal -->
<div class="modal fade" id="exampleModal{{$products->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete product</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<div class="modal-body">
				Are you want to delete product with all its varient.
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<a href="{{route('shopdeleteproduct', $products->id)}}" class="btn btn-primary">Delete</a>
			</div>
		</div>
	</div>
</div>
@endforeach   
@endsection