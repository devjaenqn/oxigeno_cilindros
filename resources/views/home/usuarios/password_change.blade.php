@extends('template')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Usuarios</li>
@endsection
@push('css')

@endprepend
@section('contenido')
  <div class="row">
        <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Usuario - Cambiar contraseña
          <div class="card-header-actions">
          </div>
        </div>
        <div class="card-body">
          <form method="post" action="{{ url('api/usuarios/'.Session::get('usuario_data')->id) }}">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="modo" value="cambiar_password">
             @if(Session::has('error_login') && Session::get('error_login'))
              <p class="text-muted" id="show_msg">{{ Session::get('error_msg') }}</p>
            @else
              <p class="text-muted" id="show_msg">Ingrese contraseñas: actual y nueva</p>
            @endif
            <div class="form-group row">
              <label for="old_pass" class="col-sm-2 form-control-label">Contraseña actual</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="old_pass" id="old_pass"  placeholder="Contraseña actual">
              </div>
            </div>
            <div class="form-group row">
              <label for="new_pass" class="col-sm-2 form-control-label">Contraseña nueva</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="new_pass" id="new_pass"  placeholder="Contraseña nueva">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-sm btn-primary" type="submit">
                  <i class="fa fa-dot-circle-o"></i> Registrar
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('templates')
  <template id="registro">


  </template>
@endsection


@push('script')

{{-- <script src="{{ url('js/home/usuarios/registro.js') }}"></script> --}}
  {{-- <script src="{{ url('jaen.js') }}"></script> --}}
@endpush