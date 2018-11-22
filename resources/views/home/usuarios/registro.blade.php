@extends('template')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Usuarios</li>
@endsection
@push('css')

@endprepend
@section('contenido')
  <div class="row">
    <registro></registro>
  </div>
@endsection
@section('templates')
  <template id="registro">

    <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Usuario - Crear
          <div class="card-header-actions">
          </div>
        </div>
        <div class="card-body">
          <form @submit.prevent="onSubmit_registrar" ref="frm_usuario">
            <div class="form-group row">
              <label for="nombre" class="col-sm-2 form-control-label">Nombres</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="nombre" id="nombre"  placeholder="Nombres">
              </div>
            </div>
            <div class="form-group row">
              <label for="apellidos" class="col-sm-2 form-control-label">Apellidos</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="apellidos" id="apellidos"  placeholder="Apellidos">
              </div>
            </div>
            <div class="form-group row">
              <label for="dni" class="col-sm-2 form-control-label">Dni</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="dni" id="dni"  placeholder="Dni">
              </div>
            </div>
            <div class="form-group row">
              <label for="telefono" class="col-sm-2 form-control-label">Teléfono</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="telefono" id="telefono"  placeholder="Teléfono">
              </div>
            </div>
            <div class="form-group row">
              <label for="direccion" class="col-sm-2 form-control-label">Dirección</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="direccion" id="direccion"  placeholder="Dirección">
              </div>
            </div>
            <hr>
            <div class="form-group row">
              <label for="cuenta" class="col-sm-2 form-control-label">Cuenta</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="cuenta" id="cuenta"  placeholder="Cuenta">
              </div>
            </div>
            <div class="form-group row">
              <label for="cuenta" class="col-sm-2 form-control-label">Tipo</label>
              <div class="col-sm-10">

                <select  name="tipo" id="tipo"  class="form-control" required="required">
                  @foreach (\App\Roles::all() as $element)
                    <option value="{{ $element->id }}">{{ strtoupper($element->name) }}</option>
                  @endforeach

                </select>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-offset-2 col-sm-10">
                <button class="btn btn-sm btn-primary" type="submit">
                  <i class="fa fa-dot-circle-o"></i> Registrar
                </button>
                <a href="{{ url('home/usuarios') }}" class="btn btn-sm btn-success"><i class="fa fa-table"></i> Listar usuarios</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
@endsection


@push('script')

<script src="{{ url('js/home/usuarios/registro.js') }}"></script>
  {{-- <script src="{{ url('jaen.js') }}"></script> --}}
@endpush