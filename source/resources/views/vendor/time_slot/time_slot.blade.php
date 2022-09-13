@extends('vendor.layout.app')

@section ('content')


<!-- Begin Page Content -->
<div class="container-fluid">
 

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">time slot</h6>
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
            <th>open time</th>
            <th>close time</th>
            <th>days</th>
            <th>status</th>
            <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
            <th>S.No</th>
            <th>open time</th>
            <th>close time</th>
            <th>days</th>
            <th>status</th>
            <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
          @if(count($time)>0)
                          @php $i=1; @endphp
                          @foreach($time as $times)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$times->open_hour}}</td>
                            <td>{{$times->close_hour}}</td>
                            <td>{{$times->days}}</td>
                            <td>
                            @if($times->status==0)
                            <span style="color:green;">On</span>
                                @else
                                    <span style="color:red;">Off</span>
                                @endif
                            </td>

                            <td>
                               <a href="{{route('edittimeslot',$times->time_slot_id)}}" style="width: 28px; padding-left: 6px;" class="btn btn-info"  style="width: 10px;padding-left: 9px;" style="color: #fff;"><i class="fa fa-edit" style="width: 10px;"></i></a>
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