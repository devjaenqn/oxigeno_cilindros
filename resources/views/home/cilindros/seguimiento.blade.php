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
              <form class="form-horizontal" @submit.prevent="onSubmit_frmAplicarFiltro()">
                <div class="row">

                 {{--  <div class="col-sm-6">
                    <div class="form-group row">
                      <!-- <label class="col-md-3 col-form-label" for="text-input">Text Input</label> -->
                      <div class="col-md-24">
                        <input class="form-control" id="guia_recibo" type="text" name="guia_recibo" placeholder="Guía, recibo" v-model="filtros.query">
                      </div>
                    </div>
                  </div> --}}
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

                    <div class="col-sm-12">
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
                    <th>ACCIONES</th>
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
    
  </template>
@endsection
@push('script')
  <script>
    var CURRENT_URL = '{{ url()->current() }}'
    const DATA_VUE = {!! json_encode($js) !!};
    function getCilindro () {
      return {{ $cilindro->cil_id }}
    }
  </script>
@endpush