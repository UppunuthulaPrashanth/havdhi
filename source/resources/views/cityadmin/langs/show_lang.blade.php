@extends('cityadmin.layout.app')

@section ('content')


<!-- Begin Page Content -->
<div class="container-fluid">
 

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">App Languages</h6>
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
        <a class="btn btn-success m-auto" style="float: right;" href="{{route('lang_add')}}">Add</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
           <table id="datatableDefault" class="table text-nowrap w-100 table-striped">
          <thead>
            <tr>
            <th>S.No</th>
            <th>Language</th>
			<th>Lang prefix</th>
		
            <th>Action</th>
            </tr>
          </thead>
         
          <tbody>
          @if(count($adminlang)>0)
          @php $i=1; @endphp
          @foreach($adminlang as $adminlang)
        <tr>
            <td>{{$i}}</td>
            <td>{{$adminlang->lang_name}}</td>
			<td align="center">{{$adminlang->lang_prefix}}</td>
		
              <td>
              <a href="{{route('lang_delete', [$adminlang->lang_id])}}" onClick="return confirm('Are you sure? This will delete your all added translations related to this language & you can not restore it');" class="btn btn-danger">Delete</a>
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

@endsection