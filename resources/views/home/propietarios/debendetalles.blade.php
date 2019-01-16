@extends('template')
@push('css')
  <link rel=stylesheet href="{{ url('vendors/datatable/datatables.css') }}">
@endpush
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
  <li class="breadcrumb-item "><a href="{{ url('home/propietarios') }}">Propietarios</a></li>
  <li class="breadcrumb-item active">{{$propietario->nombre}}</li>
@endsection
@section('contenido')
  <div class="col-lg-24" id="debe_cilindros">
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> {{$propietario->nombre}}
        <div class="card-header-actions">
        </div>
      </div>
      <form class="form-horizontal" @submit.prevent="frmOnSubmit_frmRegistro" ref="frmRegistro">
      <div class="card-body">

        <div class="row">
          <div class="col-sm-24">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
              <div class="row">

                <div class="col-sm-8">
                  <div class="form-group row">
                    <!-- <label class="col-md-3 col-form-label" for="text-input">Text Input</label> -->
                    <div class="col-md-24">
                      <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Ingrese código cilindro">
                    </div>
                  </div>
                </div>
                <div class="col-sm-8">
                   <div class="form-group row">
                    <!-- <label class="col-md-3 col-form-label">Debe cilindros</label> -->
                    <div class="col-md-18 col-form-label">
                      {{-- <div class="form-check form-check-inline mr-1">
                        <input class="form-check-input" id="inline-checkbox1" type="checkbox" value="check1">
                        <label class="form-check-label" for="inline-checkbox1">Debe cilindros</label>
                      </div> --}}
                      <!-- <div class="form-check form-check-inline mr-1">
                        <input class="form-check-input" id="inline-checkbox2" type="checkbox" value="check2">
                        <label class="form-check-label" for="inline-checkbox2">Two</label>
                      </div>
                      <div class="form-check form-check-inline mr-1">
                        <input class="form-check-input" id="inline-checkbox3" type="checkbox" value="check3">
                        <label class="form-check-label" for="inline-checkbox3">Three</label>
                      </div> -->
                    </div>
                  </div>
                </div>
                <div class="col-sm-8">
                  <div class="float-right">
                    <button class="btn btn-sm btn-primary" type="submit">
                        <i class="fa fa-dot-circle-o"></i> Aplicar filtro</button>
                    {{-- <router-link to="/registro" class="btn btn-sm btn-success"><i class="fa fa-dot-circle-o"></i> Agregar nuevo</router-link> --}}
                  </div>

                </div>
              </div>
            </form>
          </div>

        </div>

        <table class="table table-responsive-sm table-sm" id="tbl_datatable">
          <thead>
            <tr>
              <th>CILINDRO</th>
              <th>SITUACIÓN</th>
              <th>GUÍA</th>
              <th>DESDE</th><!--PRIMER CILINDRO QUE DEBE-->
              {{-- <th>ACCIONES</th> --}}
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <form class="form-horizontal"  >
          
          {{-- <button class="btn btn-sm btn-primary" type="submit">
            <i class="fa fa-dot-circle-o"></i> Agregar</button> --}}
          <a class="btn btn-primary btn-sm" target="_blank" :href="print_url" role="button"><i class="fa fa-print"></i>&nbsp;Imprimir</a>
          <a href="{{ url('home/propietarios/deben') }}" class="btn btn-sm btn-success" >
            <i class="fa fa-table"></i> Listar propietarios</a>
        </form>
      </div>
      </form>
    </div>
  </div>
<template id="tmpl_registro_propietarios"></template>
@endsection
@section('templates')
@endsection
@if ($propietario)
  @push('script')
    <script>
      var CURRENT_URL = '{{ url()->current() }}'
    </script>
    <script src="{{ url('js/home/cilindros/colores_cilindro.js') }}"></script>
    <script src="{{ url('vendors/datatable/datatables.js') }}"></script>
    <script type="text/javascript">
      var ENTIDAD_ID = {{ $propietario->ent_id }};
    </script>
    <script src="{{ url('js/home/propietarios/deben_detalles.js') }}"></script>
  @endpush
@endif