<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      {{-- <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="nav-icon icon-speedometer"></i> Dashboard
          <span class="badge badge-primary">NEW</span>
        </a>
      </li> --}}
      {{-- <li class="nav-title">Theme</li> --}}
      {{-- <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-puzzle"></i> Cilindros</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('home/cilindro') }}">
              <i class="nav-icon icon-puzzle"></i> Listar</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('home/cilindro') }}">
              <i class="nav-icon icon-puzzle"></i> Cambiar situac</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('home/cilindro/create') }}">
              <i class="nav-icon icon-puzzle"></i> Crear</a>
          </li>


        </ul>
      </li> --}}

      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-puzzle"></i> CILINDRO</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/cilindro') }}">
              <i class="nav-icon icon-puzzle"></i>    Lista</a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/cilindro/create') }}">
              <i class="nav-icon icon-puzzle"></i>    Registro</a>
          </li>
        </ul>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" href="{{ url('home/produccion') }}">
          <i class="nav-icon icon-pencil"></i> Producción</a>
      </li> --}}
      <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-puzzle"></i> PRODUCCIÓN</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/produccion') }}">
              <i class="nav-icon icon-puzzle"></i>    Lista</a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/produccion/create') }}">
              <i class="nav-icon icon-puzzle"></i>    Registro</a>
          </li>
        </ul>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" href="{{ url('home/propietarios') }}">
          <i class="nav-icon icon-pencil"></i> Propietarios</a>
      </li> --}}

      <li class="nav-item nav-dropdown" >
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-pencil"></i> PROPIETARIOS</a>

        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/propietarios') }}">
              <i class="nav-icon icon-pencil"></i>    Gestion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/propietarios/deben') }}">
              <i class="nav-icon icon-pencil"></i> Poseen Cilindros</a>
          </li>
        </ul>
      </li>
      <li class="nav-item nav-dropdown" >
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-pencil"></i> DESPACHO</a>

        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/despacho') }}">
              <i class="nav-icon icon-pencil"></i>    Lista</a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/despacho/create') }}">
              <i class="nav-icon icon-pencil"></i>    Registro</a>
          </li>
        </ul>
      </li>
      <li class="nav-item nav-dropdown" >
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-pencil"></i> RECIBO</a>

        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/recibo') }}">
              <i class="nav-icon icon-pencil"></i>    Lista</a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/recibo/create') }}">
              <i class="nav-icon icon-pencil"></i>    Registro</a>
          </li>
        </ul>
      </li>
      @if(Session::get('usuario_data')->getRole() == 'admin')
      <li class="nav-item nav-dropdown" >
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-pencil"></i> USUARIOS</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/usuarios') }}">
              <i class="nav-icon icon-pencil"></i>    Lista</a>
          </li>
          <li class="nav-item">
            <a class="nav-link pl-2em" href="{{ url('home/usuarios/create') }}">
              <i class="nav-icon icon-pencil"></i>    Registro</a>
          </li>
        </ul>
      </li>
      @endif
      {{-- <li class="nav-title">Components</li> --}}

      {{-- <li class="divider"></li>
      <li class="nav-title">Extras</li> --}}
      {{-- <li class="nav-item nav-dropdown">
        <a class="nav-link nav-dropdown-toggle" href="#">
          <i class="nav-icon icon-star"></i> Pages</a>
        <ul class="nav-dropdown-items">
          <li class="nav-item">
            <a class="nav-link" href="login.html" target="_top">
              <i class="nav-icon icon-star"></i> Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.html" target="_top">
              <i class="nav-icon icon-star"></i> Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="404.html" target="_top">
              <i class="nav-icon icon-star"></i> Error 404</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="500.html" target="_top">
              <i class="nav-icon icon-star"></i> Error 500</a>
          </li>
        </ul>
      </li> --}}
    </ul>
  </nav>
  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>