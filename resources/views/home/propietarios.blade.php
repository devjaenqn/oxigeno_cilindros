@extends('template')
@push('css')


  <link rel=stylesheet href="{{ url('vendors/datatable/datatables.css') }}">
@endpush
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Propietarios</li>
@endsection
@section('contenido')
    <div class="row container_vue" id="vue_propietarios">
      <router-view></router-view>
      @section('view')
      @show
    </div>
    {{-- <template id="tipo_docs">
      <select name="" v-model="tipo_documento">
        @foreach ($documentos as $doc)
            <option value="{{ $doc->cod }}">{{ $doc->definicion }}</option>
        @endforeach
      </select>
    </template> --}}

<template id="tmpl_registro_propietarios">

  <div class="col-lg-24">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> Propietarios - @{{ edit ? 'Editar' : 'Registrar' }}
        <div class="card-header-actions">
        </div>
      </div>
      <form class="form-horizontal" @submit.prevent="frmOnSubmit_frmRegistro" ref="frmRegistro">
      <div class="card-body">
          <div class="row">
            <div class="col-sm-12">


              <div class="form-group row">
                <label class="col-md-6 col-form-label" for="documento">Documento</label>
                <div class="col-md-18">
                  <select id="documento" v-model="documento" class="form-control" required="">
                    @foreach ($documentos as $doc)
                        <option value="{{ $doc->cod }}">{{ $doc->definicion }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group row">
                <label class="col-md-6 col-form-label" for="numero">Número</label>
                <div class="col-md-18">
                  <input class="form-control" id="numero" v-model="numero" type="text" name="text-input" placeholder="Ingresar número de documento">
                  <span class="help-block" v-if="error.numero">Número de RUC ya existe</span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group row">
                <label class="col-md-6 col-form-label" for="nombre">Nombre</label>
                <div class="col-md-18">
                  <input class="form-control" id="nombre" type="text" name="nombre" v-model="nombre" placeholder="Nombre de cliente" required="">
                  <!-- <span class="help-block">This is a help text</span> -->
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group row">
                <label class="col-md-6 col-form-label" for="direccion">Dirección</label>
                <div class="col-md-18">
                  <input class="form-control" id="direccion" v-model="direccion" type="text" name="direccion" placeholder="Ingrese texto">
                  <!-- <span class="help-block">This is a help text</span> -->
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group row">
                <label class="col-md-6 col-form-label" for="correo">Correo</label>
                <div class="col-md-18">
                  <input class="form-control" id="correo" v-model="correo" type="email" name="correo" placeholder="Ingrese correo">
                  <!-- <span class="help-block">This is a help text</span> -->
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group row">
                <label class="col-md-6 col-form-label" for="celular">Celular</label>
                <div class="col-md-18">
                  <input class="form-control" id="celular" v-model="celular" type="text" name="celular" placeholder="Celular">
                  <!-- <span class="help-block">This is a help text</span> -->
                </div>
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group row">
                <label class="col-md-6 col-form-label" for="referencia">Referencia</label>
                <div class="col-md-18">
                  <input class="form-control" id="referencia" v-model="referencia" type="text" name="referencia" placeholder="Ingrese texto">
                  <!-- <span class="help-block">This is a help text</span> -->
                </div>
              </div>
            </div>

          </div>


      </div>
      <div class="card-footer">
        <button class="btn btn-sm btn-primary" type="submit">
          <i class="fa fa-dot-circle-o"></i> @{{ edit ? 'Actualizar' : 'Agregar' }}</button>
        <button class="btn btn-sm btn-danger" @click="btnOnClick_btnCancelar">
          <i class="fa fa-ban"></i> Listar propietarios</button>
      </div>
      </form>
    </div>
  </div>

</template>
@endsection
@section('templates')
@endsection
@push('script')
  <script src="{{ url('vendors/datatable/datatables.js') }}"></script>
  <script src="{{ url('js/home/propietarios.js') }}"></script>
@endpush