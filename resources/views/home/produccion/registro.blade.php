@extends('home.produccion')
@section('view')
  <registro></registro>
@endsection
@section('templates')
  <template id="vue_produccion_registro">
    <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Produccion - {{ $edit ? 'Editar' : 'Registrar' }}
          <div class="card-header-actions">
          </div>
        </div>
        {{-- <form class="form-horizontal" @submit.prevent="frmOnSubmit_frmRegistro" ref="frmRegistro"> --}}
        <div class="card-body">


          <div class="row">
            <div class="col-sm-8">
              {{-- <div class="card card-accent-success">

                  <div class="card-body"> --}}

                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="sistema">Sistema</label>
                      <div class="col-md-18">
                        <select name="sistema" id="sistema" v-model="sistema" class="form-control pl-2 pt-1 pr-2 pb-1" style="height: 31px" required="" form="frm_registro_produccion">
                          @if ($sistemas->count() > 0)
                            @foreach ($sistemas as $sis)
                              <option  value="{{ $sis->sis_id }}">{{ strtoupper($sis->sistema) }}</option>
                            @endforeach
                          @else
                            <option value="0">DEFINIR SISTEMAS</option>

                          @endif

                        </select>
                        {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                      </div>
                    </div>

                    {{-- <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="serie_lote">Serie</label>
                    </div> --}}
                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="numero_lote">Número</label>

                      <div class="col-md-6">
                        <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select text-uppercase" id="serie_lote"  type="text" name="serie_lote" v-model="serie_lote" placeholder="0000" required="" form="frm_registro_produccion" readonly="">
                      </div>
                      <div class="col-md-12">
                        <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="numero_lote"  type="text" name="numero_lote" v-model="numero_lote" placeholder="000000000" required="" form="frm_registro_produccion" {{ $edit ? 'readonly=""' : 'readonly=""' }}>
                        {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                      </div>
                    </div>

                    <div class="form-group row mb-1 mt-1">
                      <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="observacion">Observación</label>
                      <div class="col-md-18">

                        <textarea class="form-control pl-2 pt-1 pr-2 pb-1 text-select text-uppercase" id="observacion" name="observacion" v-model="observacion" placeholder="Ingresar observación" rows="1" form="frm_registro_produccion">
                        </textarea>
                        {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                      </div>
                    </div>

                  {{-- </div>
              </div> --}}
            </div>
            <div class="col-sm-12">
              <div class="row">

                <div class="col-sm-12">
                  <div class="form-group row mb-1 mt-1">
                    <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="fecha">Entrada</label>
                    <div class="col-md-18">
                      <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="fecha"  type="date" name="fecha_entrada" v-model="fecha" placeholder="DD/MM/YYYY" value="2018-11-11" required="" form="frm_registro_produccion">
                      {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">

                  <div class="form-group row mb-1 mt-1">
                    {{-- <label class="col-md-7 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="entrada">Entrada</label> --}}
                    <div class="col-md-24">
                      <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="entrada"  type="time" name="entrada_salida" v-model="entrada" placeholder="00:00" required="" form="frm_registro_produccion">
                      {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">

                <div class="col-sm-12">

                  <div class="form-group row mb-1 mt-1">
                    <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="fecha">Salida</label>
                    <div class="col-md-18">
                      <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="fecha"  type="date" name="fecha" v-model="fecha_salida" placeholder="DD/MM/YYYY" value="" required="" form="frm_registro_produccion">

                    </div>
                  </div>
                </div>
                <div class="col-sm-12">

                        <div class="form-group row mb-1 mt-1">
                          {{-- <label class="col-md-7 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="salida">Salida</label> --}}
                          <div class="col-md-24">
                            <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="salida"  type="time" name="salida" v-model="salida" placeholder="00:00" required="" form="frm_registro_produccion">

                          </div>
                        </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">

                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="operador">Oper.</label>
                          <div class="col-md-18">
                            <select name="operador" id="operador" v-model="operador" class="form-control pl-2 pt-1 pr-2 pb-1" style="height: 31px" required="" form="frm_registro_produccion">
                              @foreach ($operadores as $ope)
                                <option value="{{ $ope->ope_id }}"  >{{ strtoupper($ope->nombre.' '.$ope->apellidos) }}</option>
                              @endforeach
                            </select>


                          </div>
                        </div>
                </div>
                <div class="col-sm-12">

                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="turno">Turno</label>
                          <div class="col-md-18">
                            {{-- <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select text" id="turno"  type="text" name="turno" v-model="turno" placeholder="Turno" required="" form="frm_registro_produccion"> --}}
                            <select name="turno" id="turno" class="form-control pl-2 pt-1 pr-2 pb-1" required="required" v-model="turno" form="frm_registro_produccion" style="height: 31px">
                              <option value="6AM - 2PM">6AM - 2PM</option>
                              <option value="6AM - 6AM">6AM - 6AM</option>
                              <option value="2PM - 10PM">2PM - 10PM</option>
                              <option value="7PM - 7AM">7PM - 7AM</option>
                              <option value="7PM - 7AM">7PM - 7AM</option>
                            </select>

                          </div>
                        </div>
                </div>
              </div>

            </div>
           {{--  <div class="col-sm-6">




                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="fecha">Fecha</label>
                          <div class="col-md-18">
                            <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="fecha"  type="date" name="fecha" v-model="fecha" placeholder="DD/MM/YYYY" value="2018-11-11" required="" form="frm_registro_produccion">

                          </div>
                        </div>
                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="operador">Oper.</label>
                          <div class="col-md-18">
                            <select name="operador" id="operador" v-model="operador" class="form-control pl-2 pt-1 pr-2 pb-1" style="height: 31px" required="" form="frm_registro_produccion">
                              @foreach ($operadores as $ope)
                                <option value="{{ $ope->ope_id }}">{{ strtoupper($ope->nombre.' '.$ope->apellidos) }}</option>
                              @endforeach
                            </select>


                          </div>
                        </div>
                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="turno">Turno</label>
                          <div class="col-md-18">
                            <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select text" id="turno"  type="text" name="turno" v-model="turno" placeholder="Turno" required="" form="frm_registro_produccion">

                          </div>
                        </div>





            </div>
            <div class="col-sm-6">

                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-7 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="entrada">Entrada</label>
                          <div class="col-md-17">
                            <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="entrada"  type="time" name="entrada" v-model="entrada" placeholder="00:00" required="" form="frm_registro_produccion">

                          </div>
                        </div>

                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-7 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="fecha">Fecha</label>
                          <div class="col-md-17">
                            <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="fecha"  type="date" name="fecha" v-model="fecha_salida" placeholder="DD/MM/YYYY" value="" required="" form="frm_registro_produccion">

                          </div>
                        </div>
                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-7 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="salida">Salida</label>
                          <div class="col-md-17">
                            <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="salida"  type="time" name="salida" v-model="salida" placeholder="00:00" required="" form="frm_registro_produccion">

                          </div>
                        </div>
            </div> --}}
            <div class="col-sm-4">
              <div class="card card-accent-success m-0">

                  <div class="card-body p-0">
                    <p class="text-center">
                      <h5 class="text-center">CILINDROS</h3>
                      <h3 class="text-center">@{{ total_cilindros }}</h1>
                      <h5 class="text-center">LIBRAS</h3>
                      <h3 class="text-center">@{{ total_libras }}</h1>
                    </p>
                  </div>
              </div>
            </div>
          </div>


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
                          <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>

                        <tr  v-for="(cil, index) in cilindros">
                          <td>@{{ cil.serie }}</td>
                          <td>@{{ cil.propietario }}</td>
                          <td>@{{ cil.capacidad }}</td>
                          <td>@{{ cil.cantidad }}</td>
                          <td>
                            <button v-if="cil.delete" class="btn btn-sm btn-default btn-accion-table btn-acciones" @click="cilindros.splice(index,1)" type="button" data-id="${d}" data-accion="eliminar" title="Quitar cilindro"><i class="fa fa-trash"></i> </button>
                          </td>
                        </tr>
                        <tr v-if="cilindros.length == 0">
                          <td colspan="4">Agregue cilindros</td>
                        </tr>
                      </tbody>
                    </table>

                  </div>
                </div>
            </div>
          </div>
          <form class="form-horizontal"  @submit.prevent="frmOnSubmit_frmAgregaCilindro">
          <div class="row">


              <div class="col-sm-12">

                  <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="cilindro_th">Cilindro</label>
                          <div class="col-md-16">
                            <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="cilindro_th" ref="cilindro_th"  type="text" name="cilindro_th"  placeholder="00000000">
                            {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                          </div>
                        </div>

                    </div>
                    <div class="col-sm-12">

                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="capacidad">Capacidad</label>
                          <div class="col-md-16">
                            <div class="input-group">
                              <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="capacidad"  type="number" name="capacidad" v-model="cilindro.capacidad" placeholder="00,00" step=".01" style="height: 31px">
                              <div class="input-group-append" style="height: 31px">
                                <span class="input-group-text">
                                  <!-- <i class="fa fa-envelope-o"></i> -->
                                  M3
                                </span>
                              </div>

                            </div>

                            {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                          </div>
                        </div>

                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-24">

                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-4 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="propietario">Propietario</label>
                          <div class="col-md-20">
                            <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="propietario"  type="text" name="propietario" v-model="cilindro.propietario" placeholder="Nombre del propietario">
                            {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">

                        <div class="form-group row mb-1 mt-1">
                          <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="cantidad">Cantidad</label>
                          <div class="col-md-16">

                            <div class="input-group">
                              <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="cantidad"  type="number" name="cantidad" v-model="cilindro.cantidad" placeholder="00,00" step=".01" style="height: 31px">
                              <div class="input-group-append" style="height: 31px">
                                <span class="input-group-text">
                                  <!-- <i class="fa fa-envelope-o"></i> -->
                                  PSI
                                </span>
                              </div>

                            </div>

                            {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}

                          </div>
                        </div>
                    </div>
                    <div class="col-sm-12">

                      <div class="col-md-24 col-form-label">
                        <div class="form-check form-check-inline mr-1">
                          <input class="form-check-input" id="chk_perdido" type="checkbox" v-model="cilindro.marcar_salida">
                          <label class="form-check-label" for="chk_perdido">Marcar salida</label>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group row mb-1 mt-1">
                        <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="fecha">Fecha</label>
                        <div class="col-md-16">
                          <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="fecha"  type="date" name="fecha" v-model="cilindro.salida_date" placeholder="DD/MM/YYYY" value="" required="" :readonly="!cilindro.marcar_salida">
                          {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                        </div>

                      </div>
                    </div>
                    <div class="col-sm-12">

                      <div class="form-group row mb-1 mt-1">


                          <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="fecha">Hora</label>
                          <div class="col-md-16">
                            <input class="form-control pl-2 pt-1 pr-2 pb-1 text-select" id="fecha"  type="time" name="fecha" v-model="cilindro.salida_time" placeholder="HH:MM" required="" :readonly="!cilindro.marcar_salida">
                            {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                          </div>
                        </div>
                    </div>
                  </div>

              </div>

              <div class="col-sm-12">




                          <div class="row">
                            <div class="col-sm-24">

                                <div class="form-group row mb-1 mt-1">
                                  <label class="col-md-4 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="observacion_cilindro">Observación</label>
                                  <div class="col-md-20">

                                    <textarea class="form-control pt-1 pr-2 pl-2 pb-1 text-select" id="observacion_cilindro" name="observacion_cilindro" v-model="cilindro.observacion" placeholder="Ingresar observaciones">
                                    </textarea>
                                    {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                                  </div>
                                </div>
                            </div>
                          </div>

                        <div class="form-group row mt-1 mb-1">
                          <div class="col-sm-24 offset-md-4">
                            <button class="btn btn-sm btn-primary" type="submit">
                              <i class="fa fa-dot-circle-o"></i> Agregar
                            </button>
                          </div>

                        </div>
              </div>

          </div>
          </form>






        </div>
        <div class="card-footer">
          <form class="form-horizontal"  @submit.prevent="frmOnSubmit_frmRegistro" id="frm_registro_produccion">
            <button class="btn btn-sm btn-primary" type="submit">
              <i class="fa fa-dot-circle-o"></i> {{ $edit ? 'Actualizar' : 'Registrar producción' }}</button>
            <a href="{{ url('home/produccion') }}" class="btn btn-sm btn-success" >
              <i class="fa fa-table"></i> Listar producción</a>
          </form>
        </div>
        {{-- </form> --}}
      </div>
    </div>
  </template>


@endsection
@push('script')
<script type="text/javascript">
  const data_vue = {!! json_encode($js) !!};
</script>

<script src="{{ url('vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js') }}"></script>
<script src="{{ url('js/home/produccion/registro.js') }}"></script>
  {{-- <script src="{{ url('jaen.js') }}"></script> --}}
@endpush