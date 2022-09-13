<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8" />
	<title>Havadhi Admin</title>
	<link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Havadhi" />
	<meta name="author" content="analogit" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-icons/3.0.2/iconfont/material-icons.min.css" integrity="sha512-y9glprRcVESvYY3suAqBUYXx0ySbQNvbzzgvLy9F2o38Y7XCNeq/No2gnHjV3+Rjyq5ijoPZRMXotpdw6jcG4g==" crossorigin="anonymous" />

	<!-- ================== BEGIN core-css ================== -->
	<link href="{{url('assets/theme_assets/css/app.min.css')}}" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
	<link href="{{url('assets/theme_assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" />
	<!-- required css -->
<link href="{{url('assets/theme_assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{url('assets/theme_assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{url('assets/theme_assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{url('assets/theme_assets/assets/plugins/bootstrap-table/dist/bootstrap-table.min.css')}}" rel="stylesheet" />

        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">


        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        @livewireStyles
        @powerGridStyles

</head>


  <style>
      .card-header.card-header-primary {
    padding: 10px !important;
    }
    .alert {
    padding: 6px !important;
    }
    .dataTables_info{
        display:none;
    }
  
    .app-footer-fixed .app-footer {
    z-index: 999 !important;
}



  </style>
</head>

<body data-spy='scroll' data-target='#sidebar-bootstrap' data-offset='200'>
  	<div id="app" class="app">
     @include('cityadmin.layout.header')
      @include('cityadmin.layout.sidebar')
     <!-- BEGIN #content -->
		<div id="content" class="app-content">

                 @yield('content')
             </div>
        <!--footer-->
         @include('cityadmin.layout.footer')

   	        </div>
		<!-- END #content -->
		
		<!-- BEGIN btn-scroll-top -->
		<a href="#" data-click="scroll-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
		<!-- END btn-scroll-top -->
	</div>
	<!-- END #app -->
	
	<!-- ================== BEGIN core-js ================== -->
	<script src="{{url('assets/theme_assets/js/app.min.js')}}"></script>
	<!-- ================== END core-js ================== -->
	
	<!-- ================== BEGIN page-js ================== -->
	<script src="{{url('assets/theme_assets/plugins/apexcharts/dist/apexcharts.min.js')}}"></script>
	<script src="{{url('assets/theme_assets/js/demo/dashboard.demo.js')}}"></script>
		<script src="{{url('assets/theme_assets/plugins/chart.js/dist/Chart.min.js')}}"></script>
	<script src="{{url('assets/theme_assets/plugins/moment/min/moment.min.js')}}"></script>
	<script src="{{url('assets/theme_assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
	<!-- <script src="{{url('assets/theme_assets/js/demo/analytics.demo.js')}}"></script> -->
	<script src="{{url('assets/theme_assets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('assets/theme_assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('assets/theme_assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('assets/theme_assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>
    <script src="{{url('assets/theme_assets/plugins/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('assets/theme_assets/plugins/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{url('assets/theme_assets/plugins/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{url('assets/theme_assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{url('assets/theme_assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('assets/theme_assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
     <script src="{{url('assets/theme_assets/plugins/bootstrap-table/dist/bootstrap-table.min.js')}}"></script>
	<!-- ================== END page-js ================== -->
        
  @yield('line-chart')
  @yield('jquery')

<script>
  $('#datatableDefault').DataTable({
    dom: "<'row mb-3'<'col-sm-4'l><'col-sm-8 text-right'<'d-flex justify-content-end'fB>>>t<'d-flex align-items-center'<'mr-auto'i><'mb-0'p>>",
     responsive: true,
    lengthMenu: false,
    autoWidth:true,
    select: true,
    scrollX: true,
    processing:true,
    ordering:true,
   paging:false,
    buttons: [ 
      { extend: 'print', className: 'btn btn-default' },
      { extend: 'csv', className: 'btn btn-default' }
    ]
  });
</script>
<script>
  $('#datatableDefaults').DataTable({
    dom: "<'row mb-3'<'col-sm-4'l><'col-sm-8 text-right'<'d-flex justify-content-end'fB>>>t<'d-flex align-items-center'<'mr-auto'i><'mb-0'p>>",
    lengthMenu: [ 10, 20, 30, 40, 50 ],
    responsive: true,
    buttons: [ 
      { extend: 'print', className: 'btn btn-default' },
      { extend: 'csv', className: 'btn btn-default' }
    ]
  });
</script>
<script>
  $('#datatableDefaultt1').DataTable({
    dom: "<'row mb-3'<'col-sm-4'l><'col-sm-8 text-right'<'d-flex justify-content-end'fB>>>t<'d-flex align-items-center'<'mr-auto'i><'mb-0'p>>",
    lengthMenu: [ 10, 20, 30, 40, 50 ],
    responsive: true,
    buttons: [ 
      { extend: 'print', className: 'btn btn-default' },
      { extend: 'csv', className: 'btn btn-default' }
    ]
  });
</script>
<script>
  $('#datatableDefault1').DataTable({
    dom: "<'row mb-3'<'col-sm-4'l><'col-sm-8 text-right'<'d-flex justify-content-end'fB>>>t<'d-flex align-items-center'<'mr-auto'i><'mb-0'p>>",
    lengthMenu: [ 10, 20, 30, 40, 50 ],
    responsive: true,
    buttons: [ 
      { extend: 'print', className: 'btn btn-default' },
      { extend: 'csv', className: 'btn btn-default' }
    ]
  });
</script>
<script>
  $('#datatableDefault2').DataTable({
    dom: "<'row mb-3'<'col-sm-4'l><'col-sm-8 text-right'<'d-flex justify-content-end'fB>>>t<'d-flex align-items-center'<'mr-auto'i><'mb-0'p>>",
    lengthMenu: [ 10, 20, 30, 40, 50 ],
    responsive: true,
    buttons: [ 
      { extend: 'print', className: 'btn btn-default' },
      { extend: 'csv', className: 'btn btn-default' }
    ]
  });
</script>
<script>
  $('#datatableDefaults2').DataTable({
    dom: "<'row mb-3'<'col-sm-4'l><'col-sm-8 text-right'<'d-flex justify-content-end'fB>>>t<'d-flex align-items-center'<'mr-auto'i><'mb-0'p>>",
    lengthMenu: [ 10, 20, 30, 40, 50 ],
    responsive: true,
    buttons: [ 
      { extend: 'print', className: 'btn btn-default' },
      { extend: 'csv', className: 'btn btn-default' }
    ]
  });
</script>
<script>
  $('#datatableDefaults3').DataTable({
    dom: "<'row mb-3'<'col-sm-4'l><'col-sm-8 text-right'<'d-flex justify-content-end'fB>>>t<'d-flex align-items-center'<'mr-auto'i><'mb-0'p>>",
    lengthMenu: [ 10, 20, 30, 40, 50 ],
    responsive: true,
    buttons: [ 
      { extend: 'print', className: 'btn btn-default' },
      { extend: 'csv', className: 'btn btn-default' }
    ]
  });
</script>


</body>
</html>
 