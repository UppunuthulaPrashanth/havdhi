@extends('cityadmin.layout.app')

@section ('content')



        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            	<h1 class="page-header mb-3">
				Hi,{{$cityadmin->cityadmin_name}}. <small>Welcome to the Administrative area.</small>
			</h1>
          </div>

          <!-- BEGIN row -->
            <div class="row">
                <!-- BEGIN col-6 -->
                <div class="col-xl-6">
                    <!-- BEGIN card -->
                    <div class="card text-white-transparent-7 mb-3 overflow-hidden">
                        <!-- BEGIN card-img-overlay -->
                        <div class="card-img-overlay d-block d-lg-none bg-blue rounded"></div>
                        <!-- END card-img-overlay -->
                        
                        <!-- BEGIN card-img-overlay -->
                        <div class="card-img-overlay d-none d-md-block bg-blue rounded" style="background-image:url('{{url('assets/img/bg/wave-bg.png')}}'); background-position: right bottom; background-repeat: no-repeat; background-size: 100%;"></div>
                        <!-- END card-img-overlay -->
                        
                        <!-- BEGIN card-img-overlay -->
                        <div class="card-img-overlay d-none d-md-block bottom-0 top-auto">
                            <div class="row">
                                <div class="col-md-8 col-xl-6"></div>
                                <div class="col-md-4 col-xl-6 mb-n2">
                                    <img src="{{url('assets/img/page/dashboard.svg')}}" alt="" class="d-block ml-n3 mb-5" style="max-height: 310px" />
                                </div>
                            </div>
                        </div>
                        <!-- END card-img-overlay -->
                        
                        <!-- BEGIN card-body -->
                        <div class="card-body position-relative">
                            <!-- BEGIN row -->
                            <div class="row">
                                <!-- BEGIN col-8 -->
                                <div class="col-md-8">
                                    <!-- stat-top -->
                                    <div class="d-flex">
                                        <div class="mr-auto">
                                            <h5 class="text-white-transparent-8 mb-3">All booking value</h5>
                                            <h3 class="text-white mt-n1 mb-1">{{$currency->currency_sign}}{{$all_cash}}</h3>
                                            <p class="mb-1 text-white-transparent-6 text-truncate">
                                                 <b></b>Here is the sum of total pending and completed booking value of all vendors
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <hr class="hr-transparent bg-white-transparent-2 mt-3 mb-3" />
                                    
                                    <!-- stat-bottom -->
                                    <div class="row">
                                        <div class="col-6 col-lg-5">
                                            <div class="mt-1">
                                                <i class="fa fa-fw fa-shopping-bag fs-28px text-black-transparent-5"></i>
                                            </div>
                                            <div class="mt-1">
                                                <div>Completed Bookings value</div>
                                                <div class="font-weight-600 text-white">{{$currency->currency_sign}}{{$total_cash}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-lg-5">
                                            <div class="mt-1">
                                                <i class="fa fa-fw fa-retweet fs-28px text-black-transparent-5"></i>
                                            </div>
                                            <div class="mt-1">
                                                <div>Pending Bookings Value</div>
                                                <div class="font-weight-600 text-white">{{$currency->currency_sign}}{{$pen_cash}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr class="hr-transparent bg-white-transparent-2 mt-3 mb-3" />
                                    
                                    
                                    
                                </div>
                                <!-- END col-8 -->
                                
                                <!-- BEGIN col-4 -->
                                <div class="col-md-4 d-none d-md-block" style="min-height: 380px;"></div>
                                <!-- END col-4 -->
                            </div>
                            <!-- END row -->
                        </div>
                        <!-- END card-body -->
                    </div>
                    <!-- END card -->
                </div>
                <!-- END col-6 -->
                
                <!-- BEGIN col-6 -->
                <div class="col-xl-6">
                    <!-- BEGIN row -->
                    <div class="row">
                        <!-- BEGIN col-6 -->
                        <div class="col-sm-6">
                            <!-- BEGIN card -->
                            <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-orange" style="min-height: 202px;">
                              
                                
                                <!-- BEGIN card-body -->
                                <div class="card-body position-relative">
                                    <h5 class="text-white-transparent-8 mb-3 fs-16px">Completed Bookings</h5>
                                    <h3 class="text-white mt-n1">{{$comp_book}}</h3>
                                     <div class="progress bg-black-transparent-5 mb-2" style="height: 6px">
                                        <div class="progrss-bar progress-bar-striped bg-white" style="width: 100%"></div>
                                    </div>
                                    <div class="text-white-transparent-8 mb-4"></i> here is the count of total<br />Completed Bookings</div>
                                    
                                </div>
                                <!-- BEGIN card-body -->
                            </div>
                            <!-- END card -->
                            
                            <!-- BEGIN card -->
                            <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-teal" style="min-height: 202px;">
                              
                    
                                <!-- BEGIN card-body -->
                                <div class="card-body position-relative">
                                    <h5 class="text-white-transparent-8 mb-3 fs-16px">Pending Bookings</h5>
                                    <h3 class="text-white mt-n1">{{$pen_book}}</h3>
                                    <div class="progress bg-black-transparent-5 mb-2" style="height: 6px">
                                        <div class="progrss-bar progress-bar-striped bg-white" style="width: 100%"></div>
                                    </div>
                                    <div class="text-white-transparent-8 mb-4"></i>here is the count of <br />Pending Bookings</div>
                                    
                                </div>
                                <!-- END card-body -->
                            </div>
                            <!-- END card -->
                        </div>
                        <!-- END col-6 -->
                        
                        <!-- BEGIN col-6 -->
                        <div class="col-sm-6">
                            <!-- BEGIN card -->
                            <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-pink" style="min-height: 202px;">
                              
                                
                                <!-- BEGIN card-body -->
                                <div class="card-body position-relative">
                                    <h5 class="text-white-transparent-8 mb-3 fs-16px">Total Salons</h5>
                                    <h3 class="text-white mt-n1">{{$vendor}}</h3>
                                    <div class="progress bg-black-transparent-5 mb-2" style="height: 6px">
                                        <div class="progrss-bar progress-bar-striped bg-white" style="width: 100%"></div>
                                    </div>
                                    <div class="text-white-transparent-8 mb-4"></i> here is the count<br /> of total Salons</div>
                                   
                                </div>
                                <!-- END card-body -->
                            </div>
                            <!-- END card -->
                            
                            <!-- BEGIN card -->
                            <div class="card mb-3 overflow-hidden fs-13px border-0 bg-gradient-custom-indigo" style="min-height: 202px;">
                            
                                
                                <!-- BEGIN card-body -->
                                <div class="card-body position-relative">
                                    <h5 class="text-white-transparent-8 mb-3 fs-16px">Total Users</h5>
                                    <h3 class="text-white mt-n1">{{$user}}</h3>
                                    <div class="progress bg-black-transparent-5 mb-2" style="height: 6px">
                                        <div class="progrss-bar progress-bar-striped bg-white" style="width: 100%"></div>
                                    </div>
                                    <div class="text-white-transparent-8 mb-4"></i>here is the count <br />of all the users</div>
                                    
                                </div>
                                <!-- END card-body -->
                            </div>
                            <!-- END card -->
                        </div>
                        <!-- BEGIN col-6 -->
                    </div>
                    <!-- END row -->
                </div>
                <!-- END col-6 -->
            </div>
            <!-- END row -->
            
           
        </div>
@endsection