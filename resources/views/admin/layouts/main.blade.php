<html>

  <head>

    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta content="A fully responsive admin theme which can be used to build CRM, CMS,ERP etc." name="description" />

    <meta content="Techzaa" name="author" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->



    <script src="{{asset('js/config.js')}}"></script>



    <link rel="shortcut icon" href="{{asset('public/dist/img/favicon.ico')}}">



    <!-- Vector Map css -->

    <link rel="stylesheet" href="{{asset('css/vendor/jquery-jvectormap-1.2.2.css')}}">


		<script type="text/javascript" src="{{ asset('js/sweetalert.min.js')}}"></script>



    <!-- Icons css -->



    {{-- <link href="{{asset('css/remixicon.css')}}" rel="stylesheet" type="text/css"  >

    <link href="{{asset('css/remixicon.min.css')}}" rel="stylesheet" type="text/css"  > --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css"  />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css" />

    <!-- App css -->

    <link href="{{asset('css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    



    <link href="{{asset('css/select2.min.css')}}"  rel="stylesheet" type="text/css" >



    <link href="{{asset('css/vendor/dataTables.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('css/vendor/responsive.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('css/vendor/fixedColumns.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('css/vendor/fixedHeader.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('css/vendor/buttons.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('css/vendor/select.bootstrap5.min.css')}}" rel="stylesheet" type="text/css" />





    <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">

    {{-- <link href="{{asset('css/adminlte.min.css')}}"  rel="stylesheet" type="text/css" > --}}



    <link href="{{asset('css/toastr.min.css')}}"  rel="stylesheet" type="text/css" >



    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>



    

      

    @yield('css')



  </head>





  <body>

  @include('admin.layouts.header')



    

    @include('admin.layouts.left-sidebar')

       <!-- ============================================================== -->

        <!-- Start Page Content here -->

        <!-- ============================================================== -->

      

         

        @yield('content')

   

        <!-- ============================================================== -->

        <!-- End Page content -->

        <!-- ============================================================== -->

        

    

    @include('admin.layouts.footer')



    @include('admin.layouts.right-sidebar')



    <script type="text/javascript" src="{{ asset('js/course.js') }}"></script>

    <!-- Daterangepicker js -->

    <script src="{{asset('js/moment.min.js')}}"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script> --}}





    {{-- <script src="{{asset('js/daterangepicker.js')}}"></script> --}}



    <!-- Apex Charts js

    <script src="{{asset('js/apexcharts.min.js')}}"></script> -->



    <!-- Vector Map js -->

    {{-- <script src="{{asset('js/jquery-jvectormap-1.2.2.min.js')}}"></script> --}}

    {{-- <script src="{{asset('js/jquery-jvectormap-world-mill-en.js')}}"></script> --}}





    <!-- Dashboard App js -->

    {{-- <script src="{{asset('js/pages/dashboard.js')}}"></script> --}}



    <script src="{{asset('js/jquery.validate.min.js')}}"></script>



    <script src="{{asset('js/toastr.min.js')}}"></script>

    <!-- App js -->

    <script src="{{asset('js/app.min.js')}}"></script>


    


 

    </script>

    @yield('js')

</body>

</html>

