@extends('home.cilindros')
@section('view')
	<seguimientotres></seguimientotres>
@endsection

@section('templates')
<template id="vue_cilindro_seguimiento_tres">
  <div class="col-lg-24">
  	<div class="card">
  		<div class="card-header">
          <i class="fa fa-align-justify"></i> Seguimiento cilindro {{ $cilindro->serie }}, {{ $cilindro->propietario->nombre }}
          <div class="card-header-actions">
          </div>
  		</div>
  		<div class="card-body">
        <div class="row">
          <div class="col-sm-24">
            <form class="form-horizontal" @submit.prevent="onSubmit_frmAplicarFiltro">
              <div class="row">

                <div class="col-sm-6">
                  <div class="form-group row">
                    <!-- <label class="col-md-3 col-form-label" for="text-input">Text Input</label> -->
                    <div class="col-md-24">
                      <input class="form-control" id="guia_recibo" type="text" name="guia_recibo" placeholder="Guía, recibo" v-model="filtros.query">
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                   <div class="form-group row">
                      <label class="col-md-3 col-form-label" for="text-input">Desde</label>
                      <div class="col-md-9">
                        <input class="form-control" id="text-input" type="date" name="text-input" placeholder="DD/MM/YYYY" v-model="filtros.fecha_desde">
                      </div>
                      <label class="col-md-3 col-form-label" for="text-input">Hasta</label>
                      <div class="col-md-9">
                        <input class="form-control" id="text-input" type="date" name="text-input" placeholder="DD/MM/YYYY" v-model="filtros.fecha_hasta">
                      </div>

                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="float-right">
                      <a class="btn btn-primary" target="_blank" :href="print_url" role="button">Imprimir</a>
                      <button class="btn btn-sm btn-primary" type="submit">
                          <i class="fa fa-dot-circle-o"></i> Aplicar filtro</button>
                    </div>


                  </div>

              </div>
            </form>
          </div>


        </div>
        <div class="row">
						<div class="col-sm-24">
              <table class="table table-responsive-sm table-sm table-bordered table-inverse table-hover table-minimal" id="tbl_seguimiento_cilindro_tres">
                <thead>
                  <tr>
                    <th>SEG_ID</th>
                    <th>CIL_ID</th>
                    <th>CREADO</th>
                    <th>MODIFICADO</th>
                    <th>DES</th>
                    <th>EVENTO</th>
                    <th>REF_ID</th>
                    <th>DOC</th>
                    <th>FECHA</th>
                    <th>ORDEN</th>
                    <th>ORIGEN</th>
                    <th>FORZADO</th>


                  </tr>
                </thead>
                <tbody>
                	<tr v-for="item in seguimiento">
                		<td>@{{ item.cis_id }}</td>
                		<td>@{{ item.cilindro_id }}</td>
                		<td>@{{ item.created_at }}</td>
                		<td>@{{ item.updated_at }}</td>
                		<td>@{{ item.descripcion }}</td>
                		<td>@{{ item.evento_id }}</td>
                		<td>@{{ item.referencia_id }}</td>
                		<td>@{{ item.referencia != null ? item.referencia.doc_serie + '-' + item.referencia.doc_numero : '' }}</td>
                		<td>@{{ item.fecha }}</td>
                		<td>@{{ item.orden_seg }}</td>
                		<td>@{{ item.origen }}</td>
                		<td>@{{ item.forzado }}</td>
                	</tr>
                </tbody>
              </table>
            </div>
          </div>
  		</div>

      <div class="card-footer">
        <form class="form-horizontal"  @submit.prevent="frmOnSubmit_frmRegistro" id="">
          @if ($success)
          <button class="btn btn-sm btn-primary" type="submit">
          <i class="fa fa-print"></i>&nbsp;Imprimir</button>
          @endif
          <a href="{{ url('home/cilindro') }}" class="btn btn-sm btn-success" >
          <i class="fa fa-table"></i> Listar cilindros</a>
        </form>
      </div>
  	</div>
  </div>
</template>
@endsection


@push('script')
  <script>
    var CURRENT_URL = '{{ url()->current() }}'
    function getCilindro () {
      return {{ $cilindro->cil_id }}
    }
  </script>
@endpush