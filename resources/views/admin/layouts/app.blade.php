<!DOCTYPE html>
<html dir="ltr" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="keywords"
      content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template"
    />
    <meta
      name="description"
      content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework"
    />
    <meta name="robots" content="noindex,nofollow" />
    <title>Consultant</title>
    <!-- Favicon icon -->
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="{{asset('/assets/images/favicon.png')}}"
    />

    <link
        rel="stylesheet"
        type="text/css"
        href="{{asset('/assets/extra-libs/multicheck/multicheck.css')}}"
    />
    <link
        href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}"
        rel="stylesheet"
    />

    <link
    rel="stylesheet"
    type="text/css"
    href="{{asset('/assets/libs/select2/dist/css/select2.min.css')}}"
    />
    <link
        rel="stylesheet"
        type="text/css"
        href="{{asset('/assets/libs/jquery-minicolors/jquery.minicolors.css')}}"
    />
    <link
        rel="stylesheet"
        type="text/css"
        href="{{asset('/assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}"
    />
    <link
        rel="stylesheet"
        type="text/css"
        href="{{asset('/assets/libs/quill/dist/quill.snow.css')}}"
    />

    <!-- Custom CSS -->
    <link href="{{asset('/assets/libs/flot/css/float-chart.css')}}" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="{{asset('/dist/css/style.min.css')}}" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link href="{{asset('/assets/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/css/buttons.dataTables.min.css')}}" rel="stylesheet">

  </head>

  <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
      <!-- ============================================================== -->
      <!-- Topbar header - style you can find in pages.scss -->
      <!-- ============================================================== -->
        @include('admin.section.topbar')
      <!-- ============================================================== -->
      <!-- End Topbar header -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
        @include('admin.section.leftbar')
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- Page wrapper  -->
      <!-- ============================================================== -->
      <div class="page-wrapper">

        @yield('content')


         <!-- ============================================================== -->
          <!-- End Container fluid  -->
          <!-- ============================================================== -->
          <!-- ============================================================== -->
          <!-- footer -->
          <!-- ============================================================== -->
          @include('admin.section.footer')
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End Page wrapper  -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('/assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('/assets/extra-libs/sparkline/sparkline.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('/dist/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('/dist/js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('/dist/js/custom.min.js')}}"></script>
    <!--This page JavaScript -->
    <!-- <script src="../dist/js/pages/dashboards/dashboard1.js"></script> -->
    <!-- Charts js Files -->

    <script src="{{asset('/assets/libs/flot/excanvas.js')}}"></script>
    <script src="{{asset('/assets/libs/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('/assets/libs/flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('/assets/libs/flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('/assets/libs/flot/jquery.flot.stack.js')}}"></script>
    <script src="{{asset('/assets/libs/flot/jquery.flot.crosshair.js')}}"></script>
    <script src="{{asset('/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{asset('/dist/js/pages/chart/chart-page-init.js')}}"></script>

    <script src="{{asset('/assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js')}}"></script>
    <script src="{{asset('/dist/js/pages/mask/mask.init.js')}}"></script>
    <script src="{{asset('/assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('/assets/libs/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('/assets/libs/jquery-asColor/dist/jquery-asColor.min.js')}}"></script>
    <script src="{{asset('/assets/libs/jquery-asGradient/dist/jquery-asGradient.js')}}"></script>
    <script src="{{asset('/assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js')}}"></script>
    <script src="{{asset('/assets/libs/jquery-minicolors/jquery.minicolors.min.js')}}"></script>
    <script src="{{asset('/assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('/assets/libs/quill/dist/quill.min.js')}}"></script>


    {{-- scripts for datatable --}}
    <script src="{{asset('/assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('/assets/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('/assets/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('/assets/js/buttons.print.min.js')}}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> --}}
    <script src="{{asset('/assets/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('/assets/js/dataTables.select.min.js')}}"></script>

    @stack('scripts')
    @yield('footerscript')


    <script>
        //***********************************//
        // For select 2
        //***********************************//
        $(".select2").select2();

        /*colorpicker*/
        $(".demo").each(function () {
          //
          // Dear reader, it's actually very easy to initialize MiniColors. For example:
          //
          //  $(selector).minicolors();
          //
          // The way I've done it below is just for the demo, so don't get confused
          // by it. Also, data- attributes aren't supported at this time...they're
          // only used for this demo.
          //
          $(this).minicolors({
            control: $(this).attr("data-control") || "hue",
            position: $(this).attr("data-position") || "bottom left",

            change: function (value, opacity) {
              if (!value) return;
              if (opacity) value += ", " + opacity;
              if (typeof console === "object") {
                console.log(value);
              }
            },
            theme: "bootstrap",
          });
        });
        /*datwpicker*/
        jQuery(".mydatepicker").datepicker();
        jQuery("#datepicker-autoclose").datepicker({
          autoclose: true,
          todayHighlight: true,
        });
        var quill = new Quill("#editor", {
          theme: "snow",
        });
      </script>

        @include('admin.section.notify')

  </body>
</html>
