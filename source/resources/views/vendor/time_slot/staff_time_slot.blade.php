@extends('vendor.layout.app')

@section ('content')


<!-- Begin Page Content -->
<div class="container-fluid">
 

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Staff Availability Time Slot <a class="btn btn-success" style="float:right;" href="{{route('staff_addtimeslot')}}">Add Slot</a></h6>
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
            <th>status</th>
            <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
            <th>S.No</th>
            <th>open time</th>
            <th>close time</th>
            <th>status</th>
            <th>Action</th>
            </tr>
          </tfoot>
          <tbody>
          @if(count($time_slot)>0)
              @foreach($time_slot as $time_slot_index=>$time_slot_row)
                        <tr>
                            <td>{{++$time_slot_index}}</td>
                            <td>{{date('h:i A',strtotime($time_slot_row->open_hour))}}</td>
                            <td>{{date('h:i A',strtotime($time_slot_row->close_hour))}}</td>
                            <td>
                                @if($time_slot_row->status==0)
                                <span style="color:green;">Active</span>
                                @else
                                <span style="color:red;">Inactive</span>
                                @endif
                            </td>

                            <td>
                               <a href="{{route('staff_edittimeslot',$time_slot_row->id)}}" style="width: 28px; padding-left: 6px;" class="btn btn-info"  style="width: 10px;padding-left: 9px;" style="color: #fff;"><i class="fa fa-edit" style="width: 10px;"></i></a>
							</td>

                        </tr>
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