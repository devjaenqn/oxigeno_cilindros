@extends('home.cilindros')
@section('view')
  <seguimiento></seguimiento>
@endsection
@section('templates')
  <template id="vue_cilindro_seguimiento">
    <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Seguimiento cilindro {{ $cilindro->serie }}, {{ $cilindro->propietario->nombre }}
          <div class="card-header-actions">
          </div>
        </div>
        <div class="card-body">
          @if ($success)

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
              <table class="table table-responsive-sm table-sm table-bordered table-inverse table-hover table-minimal" id="tbl_seguimiento_cilindro">
                <thead>
                  <tr>
                    <th>SALIDA</th>
                    <th>DESPACHO</th>
                    <th>ENTRADA</th>
                    <th>RECIBO</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
          @else
          <div class="row">
            <div class="col-sm-24">
              <h3>ELEMENTO NO ENCONTRADO</h3>
            </div>
          </div>
          @endif
        </div>
        <div class="card-footer">
          <form class="form-horizontal"  >
            <a class="btn btn-primary btn-sm" target="_blank" :href="print_url" role="button"><i class="fa fa-print"></i>&nbsp;Imprimir</a>
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