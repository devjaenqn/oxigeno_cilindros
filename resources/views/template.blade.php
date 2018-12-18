<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="{{ url('/') }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title> {{ isset($titulo_pagina) ? ''.$titulo_pagina : '' }}</title>
    <!-- Icons-->
    <link href="vendors/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="vendors/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendors/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application-->
    {{-- <link href="css/style.css" rel="stylesheet"> --}}
    <link href="vendors/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
    <link href="css/style-app.css" rel="stylesheet">
    <link href="vendors/pace-progress/css/pace.css" rel="stylesheet">

    <link href="vendors/toastr/build/toastr.min.css" rel="stylesheet">

    <style type="text/css" media="print">

      .breadcrumb {
        display:none;
      }
      .card-footer {
        display:none;
      }
      .app-footer{
        display:none;
      }
      .container_vue .card-header{
        text-align: center;
        text-transform: uppercase;
      }
      .container_vue .card-header .fa.fa-align-justify{
        display: none;
      }
    </style>
    @stack('css')
    <script>
      const BASE_URL = "{{ url('/') }}";
      function base_url(url_ref = ''){
        return "{{ url('/') }}/" + url_ref;
      }
    </script>
  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    <div class="d-none" id="load-container">
      <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
      </div>
    </div>
    @include('includes/header')
    <div class="app-body">
      @include('includes/sidebar')
      <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
          @section('breadcrumb')
            <li class="breadcrumb-item">Home</li>
            {{-- <li class="breadcrumb-item">
              <a href="#">Admin</a>
            </li>
            <li class="breadcrumb-item active">Dashboard</li> --}}
          @show

          <!-- Breadcrumb Menu-->
         {{--  <li class="breadcrumb-menu d-md-down-none">
            <div class="btn-group" role="group" aria-label="Button group">
              <a class="btn" href="#">
                <i class="icon-speech"></i>
              </a>
              <a class="btn" href="./">
                <i class="icon-graph"></i>  Dashboard</a>
              <a class="btn" href="#">
                <i class="icon-settings"></i>  Settings</a>
            </div>
          </li> --}}
        </ol>

        <div class="container-fluid">
          <div class="animated fadeIn" id="master_vue">
            <!-- CONTENIDO -->
            @section('contenido')
              <h1>SIN CONTENIDO</h1>
            @show




            <!-- <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <i class="fa fa-align-justify"></i> Bootstrap Breadcrumb
                    <div class="card-header-actions">
                    </div>
                  </div>
                  <div class="card-body">
                    contenido
                  </div>
                </div>
              </div>
            </div> -->
            <!-- /.row-->
          </div>
        </div>
      </main>
      @include('includes/aside')
    </div>
    @include('includes/footer')
    @section('templates')
              {{-- <h1>SIN TEMPLATE</h1> --}}
    @show
    <!-- CoreUI and necessary plugins-->
    <script src="vendors/jquery/dist/jquery.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.js"></script>
    <script src="js/app.js"></script>
    <script src="vendors/autosize/dist/autosize.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/pace-progress/pace.min.js"></script>
    <script src="vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="vendors/@coreui/coreui/dist/js/coreui.min.js"></script>
    <script src="vendors/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="vendors/toastr/build/toastr.min.js"></script>
    <script src="vendors/moment/moment.min.js"></script>
    <script src="vendors/typeahead.js/dist/typeahead.bundle.js"></script>
    <script type="text/javascript">
      var localvalues = new LocalS();
      $('body').on('focus', '.text-select', function(e){
        this.select()
      })
    </script>
    @stack('script')

  </body>
</html>