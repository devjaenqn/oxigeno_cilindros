@extends('home.produccion')
@section('view')

    <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Produccion - Detalles
          <div class="card-header-actions">
          </div>
        </div>
        {{-- <form class="form-horizontal" @submit.prevent="frmOnSubmit_frmRegistro" ref="frmRegistro"> --}}
        <div class="card-body">
          <form class="form-horizontal" >

              <div class="row">
                <div class="col-sm-8">
                  {{-- <div class="card card-accent-success">

                      <div class="card-body"> --}}

                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="sistema">Sistema :</label>
                          <div class="col-md-16">
                            <p class="form-control-static m-0 ">{{ strtoupper($produccion->sistema_lote) }}</p>
                            {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                          </div>
                        </div>

                        {{-- <div class="form-group row mb-1 mt-1">
                          <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="serie_lote">Serie :</label>
                          <div class="col-md-16">
                            <p class="form-control-static m-0 ">{{ strtoupper($produccion->serie_lote) }}</p>
                          </div>
                        </div> --}}
                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="numero_lote">Número :</label>
                          <div class="col-md-16">
                            {{-- <input class="form-control p-1 text-select" id="numero_lote"  type="text" name="numero_lote" v-model="numero_lote" placeholder="000000000"> --}}
                            <p class="form-control-static m-0 ">{{ strtoupper($produccion->serie_lote) }}-{{ $produccion->numero_lote }}</p>
                            {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                          </div>
                        </div>

                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-8 col-form-label line-height-2-1 pt-0 pb-0 pr-0 text-left" for="observacion">Observación :</label>
                          <div class="col-md-16">
                            <p class="form-control-static m-0 ">{{ strtoupper($produccion->observacion) }}</p>
                          </div>
                        </div>

                      {{-- </div>
                  </div> --}}
                </div>

                  {{-- <div class="card card-accent-success">

                      <div class="card-body"> --}}
                <div class="col-sm-12">
                  <div class="row">
                    <div class="col-sm-24">
                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-12 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="fecha">Entrada :</label>
                        <div class="col-md-12">
                          <p class="form-control-static m-0 ">{{ $produccion->fecha_entrada }}</p>
                          {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                        </div>
                      </div>
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-sm-24">
                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-12 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left">Salida :</label>
                        <div class="col-md-12">
                          <p class="form-control-static m-0 ">{{ $produccion->fecha_salida }}</p>
                          {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                        </div>
                      </div>
                    </div>


                  </div>
                  <div class="row">
                    <div class="col-sm-12">

                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-9 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="operador">Operador :</label>
                        <div class="col-md-15">
                          <p class="form-control-static m-0 ">{{ strtoupper($produccion->operador->nombre.' '.$produccion->operador->apellidos) }}</p>

                          {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">

                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-9 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="turno">Turno :</label>
                        <div class="col-md-15">
                          <p class="form-control-static m-0 ">{{ $produccion->turno }}</p>
                          {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                        </div>
                      </div>
                    </div>

                  </div>
                </div>


                      {{-- </div>
                  </div> --}}

                <div class="col-sm-4">
                  <div class="card card-accent-success m-0">

                      <div class="card-body p-0">
                        <p class="text-center">
                          <h5 class="text-center">CILINDROS</h3>
                          <h3 class="text-center">{{ $produccion->total_cilindros }}</h1>
                          <h5 class="text-center">LIBRAS</h3>
                          <h3 class="text-center">{{ $produccion->total_presion }}</h1>
                        </p>
                      </div>
                  </div>
                </div>
              </div>

          </form>
          {{-- <hr class="m-2"> --}}
          <div class="row mt-2">
            <div class="col-sm-24">
              <div class="card">
                  <div class="card-body">
                    <table class="table table-responsive-sm table-sm">
                      <thead>
                        <tr>
                          <th>CILINDRO</th>
                          <th>PROPIETARIO</th>
                          <th>M3</th>
                          <th>PRESIÓN</th>
                          <th>OBSERVACIÓN</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($produccion->detalles as $cil)
                          <tr>
                            <td>
                              <a href="{{ url('home/cilindro/'.$cil->cilindro->cil_id) }}" class="none-text-decoration">{{ strtoupper($cil->cilindro->serie) }}</a>
                            </td>
                            <td>{{ strtoupper($cil->cilindro->propietario->nombre) }}</td>
                            <td>{{ $cil->pro_capacidad }}</td>
                            <td>{{ $cil->pro_presion }}</td>
                            <td>{{ strtoupper($cil->observacion) }}</td>

                          </tr>
                        @endforeach

                      </tbody>
                    </table>

                  </div>
                </div>
            </div>
          </div>
          <div class="row">

            <div class="col-sm-6">
              {{-- Libras contador --}}
            </div>

          </div>






        </div>
        <div class="card-footer">
          <form class="form-horizontal"  @submit.prevent="frmOnSubmit_frmRegistro">
            <button class="btn btn-sm btn-primary" type="button" id="btn_print">
              <i class="fa fa-print"></i>&nbsp;&nbsp;Imprimir</button>
            <a href="{{ url('home/produccion') }}" class="btn btn-sm btn-danger" >
              <i class="fa fa-table"></i>&nbsp;&nbsp;Listar producción</a>
          </form>
        </div>
        {{-- </form> --}}
      </div>
    </div>
@endsection
@section('templates')

@endsection
@push('script')
<script type="text/javascript">
  $('#btn_print').on('click', () => {
    window.print();
  })
</script>

{{-- <script src="{{ url('vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js') }}"></script>
<script src="{{ url('js/home/produccion/registro.js') }}"></script> --}}
  {{-- <script src="{{ url('jaen.js') }}"></script> --}}
@endpush