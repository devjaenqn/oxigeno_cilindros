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
      <form class="form-horizontal" @submit.prevent="frmOnSubmit_frmAplicarFiltro" ref="frmRegistro">
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
              <th>ACCIONES</th>
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
    
<!-- Modal -->
<div class="modal fade" id="model_retorno" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Agregar recibo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form id="frm_verifica" @submit.prevent="fnOnSubmit_verificar"></form>
          <form  @submit.prevent="fnOnSubmit_regRecibo" class="form-horizontal" id="frm_regitro_recibo" >
            <div class="row">
              <div class="col">
                <div class="form-group row mb-1 mt-1">
                  <label class="col-md-6 col-form-label line-height-2-1 pt-0 pr-0 pb-0 text-left" for="comprobante">Recibo</label>
                  <div class="col-md-18">
                    <select name="comprobante" required="" id="comprobante" v-model="comprobante" class="form-control pt-1 pr-2 pb-1 pl- 2" style="height: 31px" form="frm_registro_recibo">
                      @if ($negocios->count() > 0)
                        @foreach ($negocios as $neg)
                          @foreach ($neg->recibos as $recibo)
                         
                              <option value="{{ $recibo->cne_id }}">{{ strtoupper($recibo->nombre) }}</option>
                          
                          @endforeach
                        @endforeach
                      @else
                        <option value="0">DEFINIR NEGOCIOS</option>
  
                      @endif
  
                    </select>
                    {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row mb-1 mt-1">
              <label for="serie_comprobante" class="col-md-6 col-form-label line-height-2-1 pt-0 pr-0 pb-0 text-left">Num.</label> 
              <div class="col-md-9">
                
                <input form="frm_verifica" id="numero_comprobante" type="text" name="numero_comprobante" v-model="numero_doc" placeholder="000000000" class="form-control pt-1 pr-2 pb-1 pl- 2 text-select">
              </div>
              <div class="col">
                <button form="frm_verifica" type="submit"  title="Verificar" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>
              </div>
            </div>
            <div class="row">
              <div class="offset-md-6 col-md-9">
                <p class="">
                  <span v-if="procesa" class="badge badge-success">Verificado</span>
                  <span v-else class="badge badge-danger">Sin verificar</span>
                </p>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancelar</button>
          <button form="frm_regitro_recibo" type="submit" class="btn btn-sm btn-primary">Guardar</button>
        </div>
      </div>
    </div>
</div>
  </div>
<template id="tmpl_registro_propietarios"></template>
<!-- Button trigger modal -->


@endsection
@section('templates')
@endsection
@if ($propietario)
  @push('script')
    <script>
      var CURRENT_URL = '{{ url()->current() }}'
      const DATA_VUE = {!! json_encode($js) !!};
    </script>
    <script src="{{ url('js/home/cilindros/colores_cilindro.js') }}"></script>
    <script src="{{ url('vendors/datatable/datatables.js') }}"></script>
    <script type="text/javascript">
      var ENTIDAD_ID = {{ $propietario->ent_id }};
    </script>
    <script src="{{ url('js/home/propietarios/deben_detalles.js') }}"></script>
  @endpush
@endif