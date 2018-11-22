@extends('home.cilindros')
@section('view')
  <registro></registro>
@endsection
@section('templates')
  <template id="vue_cilindros_registro">
    <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Cilindros - {{ $edit ? 'Editar' : 'Registrar' }}
          <div class="card-header-actions">
          </div>
        </div>
        <form class="form-horizontal" @submit.prevent="frmOnSubmit_frmRegistro" ref="frmRegistro">
        <div class="card-body">

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-md-6 col-form-label" for="propietario">Propietario</label>
                  <div class="col-md-18">
                    <input class="form-control text-select" id="propietario" ref="propietario" type="text" name="nombre" v-model="nombre" placeholder="Nombre o número">
                    <span class="help-block" v-if="error.propietario">Seleccione un propietario</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-md-6 col-form-label" for="serie">Serie</label>
                  <div class="col-md-18">
                    <input class="form-control text-select text-uppercase" id="serie" type="text" name="serie" v-model="serie" placeholder="Serie cilindro" required="">
                    <!-- <span class="help-block">This is a help text</span> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-md-6 col-form-label" for="capacidad">Capacidad</label>
                  <div class="col-md-18">
                    <div class="input-group">
                      <input class="form-control text-select" id="capacidad" v-model="capacidad" type="number" name="capacidad" placeholder="00" step=".01" required="" min="0">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <!-- <i class="fa fa-envelope-o"></i> -->
                          M3
                        </span>
                      </div>
                    </div>

                    <!-- <span class="help-block">This is a help text</span> -->
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-md-6 col-form-label" for="presion">Presión</label>
                  <div class="col-md-18">

                    <div class="input-group">

                      <input class="form-control text-select" id="presion" v-model="presion" type="number" name="presion" placeholder="00" step=".01" required="" min="0">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <!-- <i class="fa fa-envelope-o"></i> -->
                          PSI
                        </span>
                      </div>
                    </div>
                    <!-- <span class="help-block">This is a help text</span> -->
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group row">
                  <label class="col-md-6 col-form-label" for="referencia">Tapa</label>
                  <div class="col-md-18">
                    <div class="form-check form-check-inline mr-1">
                          <input class="form-check-input" id="tapa_si" type="radio" value="1" v-model="tapa">
                          <label class="form-check-label" for="tapa_si">SI</label>
                        </div>
                    <div class="form-check form-check-inline mr-1">
                          <input class="form-check-input" id="tapa_no" type="radio" value="0" v-model="tapa">
                          <label class="form-check-label" for="tapa_no">NO</label>
                    </div>
                    <!-- <span class="help-block">This is a help text</span> -->
                  </div>
                </div>
              </div>
            </div>
            <div class="row">

            </div>


        </div>
        <div class="card-footer">
          <button class="btn btn-sm btn-primary" type="submit">
            <i class="fa fa-dot-circle-o"></i> {{ $edit ? 'Actualizar' : 'Agregar' }}</button>
          <a href="{{ url('home/cilindro') }}" class="btn btn-sm btn-success" >
            <i class="fa fa-table"></i> Listar cilindros</a>
        </div>
        </form>
      </div>
    </div>
  </template>


@endsection
@push('script')
  <script>
    var app_data = {
      edit: {{ $edit ? 'true' : 'false' }},
      id: {{ $edit ? $cilindro->cil_id : 0}},
      nombre: '{{ $edit ? $cilindro->propietario->nombre.' - '.$cilindro->propietario->numero : ''}}',
      serie: '{{ $edit ? $cilindro->serie : ''}}',
      capacidad: {{ $edit ? $cilindro->capacidad : '0' }},
      presion: {{ $edit ? $cilindro->presion : '0' }},
      tapa: {{ $edit ? $cilindro->tapa : '0' }},
      propietario: {!! $edit ? $cilindro->propietario->makeHidden(['telefono', 'direccion', 'correo'])->toJson() : 'null' !!},
      cilindro: {!! $edit ? $cilindro->makeHidden([
        'situacion',
        'cargado',
        'propietario',
        'defectuoso'])->toJson() : 'null' !!},
    }
  </script>
  {{-- <script src="{{ url('jaen.js') }}"></script> --}}
@endpush