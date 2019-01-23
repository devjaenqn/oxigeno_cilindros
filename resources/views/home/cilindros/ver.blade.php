@extends('home.cilindros')
@section('view')
<div class="col-lg-24">
  <div class="card">
    <div class="card-header">
      <i class="fa fa-align-justify"></i> Cilindros - Estado
      <div class="card-header-actions">
      </div>
    </div>
    <div class="card-body">
      @if ($success)
        <div class="row">
          <div class="col-sm-10">
            {{-- <div class="card card-accent-success">
              <div class="card-body"> --}}
                <div class="form-group row mb-1 mt-1">
                  <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="negocio">Serie : </label>
                  <div class="col-md-18">
                    <p class="form-control-static m-0 ">{{ $cilindro->serie }}
                        @if ($cilindro->situacion == 0)
                        <span class="badge badge-success rounded-2">extraviado</span>
                      @endif
                      @if ($cilindro->situacion == 1)
                        <span class="badge badge-success rounded-2">fabrica</span>
                      @endif
                      @if ($cilindro->situacion == 2)
                        <span class="badge badge-success rounded-2">transporte</span>
                      @endif
                      @if ($cilindro->situacion == 3)
                        <span class="badge badge-primary rounded-2">cliente</span>
                      @endif
            
                      @if ($cilindro->defectuoso)
                        <span class="badge badge-danger rounded-2">D</span>
                      @endif
            
                      @if ($cilindro->evento == 'create')
                        <span class="badge badge-info rounded-2">new</span>
                      @endif
                    </p>
                  </div>
                </div>
                <div class="form-group row mb-1 mt-1">
                  <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="negocio">Propietario : </label>
                  <div class="col-md-18">
                    <p class="form-control-static m-0 ">{{ strtoupper($cilindro->propietario->nombre) }}</p>
                  </div>
                </div>
                <div class="form-group row mb-1 mt-1">
                  <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="serie_comprobante">Capacidad : </label>
                  <div class="col-md-18">
                    <p class="form-control-static m-0 ">{{ $cilindro->capacidad }}</p>
                    {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                  </div>
                  <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="numero_comprobante">Tapa : </label>
                  <div class="col-md-18">
                    <p class="form-control-static m-0 ">{{ $cilindro->tapa == '1' ? 'SI' : 'NO' }}</p>
                    {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                  </div>
                </div>
                <div class="form-group row mb-1 mt-1">
                  <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="fecha_emision">Presión : </label>
                  <div class="col-md-18">
                    <p class="form-control-static m-0 ">{{ $cilindro->presion }} psi</p>
                  </div>
                </div>
                {{-- <div class="form-group row mb-1 mt-1">
                  <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="referencia">Lote serie :</label>
                  <div class="col-md-18">
                    <p class="form-control-static m-0 ">{{ '' }}</p>
                  </div>
                </div>
                <div class="form-group row mb-1 mt-1">
                  <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="referencia">Lote numero :</label>
                  <div class="col-md-18">
                    <p class="form-control-static m-0 ">{{'' }}</p>
                  </div>
                </div> --}}
                {{--  <div class="form-group row mb-1 mt-1">
                  <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="observacion">Observación :</label>
                  <div class="col-md-18">
                    <p class="form-control-static m-0 ">{{ $cilindro->codigo }}</p>
                  </div>
                </div> --}}
              {{-- </div>
            </div> --}}
          </div>
        </div>
        <hr>  
        <h4>SITUACIÓN ACTUAL</h4>
            <div class="row">
              <div class="col-sm-10">
                {{-- <div class="card card-accent-success">
                  <div class="card-body"> --}}
                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="">Situación :</label>
                      <div class="col-md-18">
                        <p class="form-control-static m-0 ">{{ $situacion['situacion'] }}</p>
                      </div>
                    </div>
                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="">Desde :</label>
                      <div class="col-md-18">
                        <p class="form-control-static m-0 ">{{ $situacion['fecha_desde'] }}</p>
                      </div>
                    </div>
                    @if (in_array('sistema', $situacion['mostrar']))
                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="">Sistema/Lote :</label>
                        <div class="col-md-18">
                          <p class="form-control-static m-0 ">{{ $situacion['sistema_lote'] }}</p>
                        </div>
                      </div>
                    @endif
                    @if (in_array('guia', $situacion['mostrar']))
                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="">Guia :</label>
                        <div class="col-md-18">
                          <p class="form-control-static m-0 ">{!! $situacion['guia'] !!}</p>
                        </div>
                      </div>
                    @endif
                    @if (in_array('recibo', $situacion['mostrar']))
                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="">Recibo :</label>
                        <div class="col-md-18">
                          <p class="form-control-static m-0 ">{{ $situacion['recibo'] }}</p>
                        </div>
                      </div>
                    @endif
                    @if (in_array('del_cliente', $situacion['mostrar']))
                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="serie_comprobante">Cliente : </label>
                      <div class="col-md-18">
                        <p class="form-control-static m-0 ">{{ $situacion['cliente'] }}</p>
                        {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                      </div>
                    </div>
                    @endif
                    @if (in_array('operador', $situacion['mostrar']))
                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="serie_comprobante">Operador :</label>
                      <div class="col-md-18">
                        <p class="form-control-static m-0 ">{{ $situacion['operador'] }}</p>
                        {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                      </div>
                    </div>
                    @endif
                    @if (in_array('cliente', $situacion['mostrar']))
                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="serie_comprobante">Operador :</label>
                      <div class="col-md-18">
                        <p class="form-control-static m-0 ">{{ $situacion['operador'] }}</p>
                        {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                      </div>
                    </div>
                    @endif
                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="referencia">Observación :</label>
                      <div class="col-md-18">
                        <p class="form-control-static m-0 ">{{ strtoupper($situacion['observacion']) }}</p>
                        @if (in_array('observacion_detalle', $situacion['mostrar']))
                        <p class="form-control-static m-0 ">{{ strtoupper($situacion['observacion_detalle']) }}</p>
                        @endif
                      </div>
                    </div>
                  {{-- </div>
                </div> --}}
              </div>
            </div>
      @else
        <div class="col-sm-24">
          <h3>ELEMENTO NO ENCONTRADO</h3>
        </div>
      @endif
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
    @endsection
    @section('templates')
    @endsection
    @prepend('script')
      <script>
        var OBJ_CILINDRO = {!! $cilindro->toJson() !!};
      </script>
    @endprepend