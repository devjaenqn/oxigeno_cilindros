<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>INGRESO DE SISTEMA</title>
    <!-- Icons-->
    <link href="vendors/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="vendors/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendors/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="css/style.css" rel="stylesheet">
    <link href="vendors/pace-progress/css/pace.css" rel="stylesheet">

    <link href="css/app.css" rel="stylesheet">

  </head>
  <body class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <form action="{{ url('api/login_usuario') }}" name="frm_login"  method="post">
                  {{-- @csrf --}}
                <h1>Iniciar sessión</h1>
                @if(Session::has('error_login') && Session::get('error_login'))
                  <p class="text-muted" id="show_msg">{{ Session::get('error_msg') }}</p>
                @else
                  <p class="text-muted" id="show_msg">Ingrese con su cuenta de usuario</p>
                @endif

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-user"></i>
                    </span>
                  </div>
                  <input class="form-control" type="text" placeholder="Usuario" name="usuario">
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-lock"></i>
                    </span>
                  </div>
                  <input class="form-control" type="password" placeholder="Cotraseña" name="password">
                </div>
                <div class="row">
                  <div class="col-12">
                    <button class="btn btn-primary " type="submit" name="btn_login"><i class="icon-login"></i>&nbsp;&nbsp;Ingresar</button>
                  </div>
                  <!-- <div class="col-6 text-right">
                    <button class="btn btn-link px-0" type="button">Forgot password?</button>
                  </div> -->
                </div>
                </form>
              </div>
            </div>
            <!-- <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                  <h2>Sign up</h2>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  <button class="btn btn-primary active mt-3" type="button">Register Now!</button>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vendors/pace-progress/pace.min.js"></script>
    <script src="vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="vendors/@coreui/coreui/dist/js/coreui.min.js"></script>
  </body>
</html>