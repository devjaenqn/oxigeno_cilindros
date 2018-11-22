@extends('home.cilindros')
@section('view')
  <situacion></situacion>
@endsection
@section('templates')
<template id="vue_cilindro_situacion">
  <div class="col-lg-24">
  <div class="card">
    <div class="card-header">
      <i class="fa fa-align-justify"></i> Cilindros - Cambiar situación
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
                    <p class="form-control-static m-0 ">{{ $cilindro->serie }}</p>
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
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="sel_ubicacion">Ubicación :</label>
                      <div class="col-md-18">
                        <select v-model="ubicacion" name="sel_ubicacion" id="sel_ubicacion" class="form-control">
                          {{-- <option value="fabrica">FABRICA</option>
                          <option value="cliente">CLIENTE</option> --}}
                          <option value="iniciar_recibo">PARA INICIAR RECIBO</option>
                          {{-- <option value="perdido">PERDIDO</option> --}}
                          option
                        </select>
                      </div>
                    </div>

                  {{-- </div>
                </div> --}}
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10">
                {{-- <div class="card card-accent-success">
                  <div class="card-body"> --}}
                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="sel_situacion">Situación :</label>
                      <div class="col-md-18">
                        <select v-model="situacion" name="sel_situacion" id="sel_situacion" class="form-control">
                          {{-- <option {{ $selected['trasegada'] ? 'selected' : '' }} value="trasegada">TRASEGADA</option>
                          <option {{ $selected['defectuosa'] ? 'selected' : '' }} value="defectuosa">DEFECTUOSA</option> --}}
                          <option {{ $selected['cargada'] ? 'selected' : '' }} value="cargada">CARGADA</option>
                          {{-- <option {{ $selected['vacio'] ? 'selected' : '' }} value="vacio">VACIO</option>
                          <option {{ $selected['cliente'] ? 'selected' : '' }} value="cliente">CLIENTE</option> --}}
                        </select>
                      </div>
                    </div>

                  {{-- </div>
                </div> --}}
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10">

                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="motivo">Motivo :</label>
                      <div class="col-md-18">
                        <input type="text" v-model="motivo" name="motivo" id="motivo" class="form-control" >
                      </div>
                    </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10">

                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="motivo">Fecha :</label>
                      <div class="col-md-18">
                        <input type="date" v-model="fecha" name="fecha" id="fecha" class="form-control"  >
                      </div>
                    </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-10">

                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="motivo">Hora :</label>
                      <div class="col-md-18">
                        <input type="time" v-model="hora" name="hora" id="hora" class="form-control"  >
                      </div>
                    </div>
              </div>
            </div>
      @else
        <div class="col-sm-24">
          <h3>ELEMENTO NO ENCONTRADO</h3>
        </div>
      @endif
        </div>
        <div class="card-footer">
          <form class="form-horizontal"  @submit.prevent="frmOnSubmit_cambiarSituacion" id="">
            <button class="btn btn-sm btn-primary" type="submit">
            <i class="fa fa-dot-circle-o"></i>&nbsp;Guardar</button>
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
  var OBJ_CILINDRO = {!! $cilindro->toJson() !!}
</script>
@endpush