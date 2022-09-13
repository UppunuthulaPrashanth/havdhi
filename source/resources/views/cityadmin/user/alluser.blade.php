@extends('cityadmin.layout.app')

@section ('content')


<!-- Begin Page Content -->
<div class="container-fluid">
 

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">App Users</h6>
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
      <div class="container">
      <table id="datatableDefault" class="table text-nowrap w-100 table-striped">
          <thead>
            <tr>
                <th>S.No</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>User Phone</th>
            </tr>
          </thead>
         
          <tbody>
          @if(count($alluser)>0)
                          @php $i=1; @endphp
                          @foreach($alluser as $user)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->user_phone}}</td>                    
                            <td>   @if($user->block==1)
               <a href="{{route('userunblock',$user->id)}}" rel="tooltip" class="btn btn-danger">
                    Blocked
                </a>
                @else
                <a href="{{route('userblock',$user->id)}}" rel="tooltip" class="btn btn-primary">
                   Active
                </a>
                @endif
                
                 <a href="{{route('del_userfromlist',$user->id)}}" rel="tooltip" onclick="return confirm('Are You sure! It will remove all the booking & orders related to this User.')" class="btn btn-danger">
                   Delete
                </a></td>
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