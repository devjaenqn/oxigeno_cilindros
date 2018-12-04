@extends('home.despacho')
@section('view')
  <registro></registro>
@endsection
@section('templates')
  <template id="vue_produccion_registro">
    <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Despacho - {{ $edit ? 'Editar' : 'Registrar' }}
          <div class="card-header-actions">
          </div>
        </div>
        {{-- <form class="form-horizontal" @submit.prevent="frmOnSubmit_frmRegistro" ref="frmRegistro"> --}}
        <div class="card-body">
          @if ($no_encontrado)
            <div class="row">
              <div class="col-sm-24"><h1>CONTENIDO NO ENCONTRADO</h1></div>
            </div>
          @else

            <form class="form-horizontal" >

                <div class="row">
                  <div class="col-sm-10">
                    {{-- <div class="card card-accent-success">

                        <div class="card-body"> --}}

                          <div class="form-group row mb-1 mt-1">
                            <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="comprobante">Guías</label>
                            <div class="col-md-18">
                              <select name="comprobante" required="" id="comprobante" v-model="comprobante" class="form-control pt-1 pr-2 pl-2 pb-1" style="height: 31px" form="frm_registro_despacho">

                                @if ($negocios->count() > 0)
                                  @foreach ($negocios as $neg)
                                    @foreach ($neg->guias as $guia)
                                      @if ($edit)
                                        @if ($despacho->documento_id == $guia->cne_id)
                                          <option value="{{ $guia->cne_id }}" selected="">{{ strtoupper($guia->nombre) }}</option>
                                        @else
                                          <option value="{{ $guia->cne_id }}">{{ strtoupper($guia->nombre) }}</option>
                                        @endif
                                      @else

                                        <option value="{{ $guia->cne_id }}">{{ strtoupper($guia->nombre) }}</option>
                                      @endif
                                    @endforeach
                                  @endforeach
                                @else
                                  <option value="0">DEFINIR NEGOCIOS</option>

                                @endif

                              </select>
                              {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                            </div>
                          </div>

                          <div class="form-group row mb-1 mt-1">
                            <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="serie_comprobante">Serie</label>
                            <div class="col-md-8">
                              <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select text-uppercase" id="serie_comprobante"  type="text" name="serie_comprobante" v-model="serie_comprobante" placeholder="0000" readonly="">
                              {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                            </div>

                            <label class="col-md-4 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="numero_comprobante">Número</label>
                            <div class="col-md-6">
                              <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select" id="numero_comprobante"  type="text" name="numero_comprobante" v-model="numero_comprobante" placeholder="000000000">
                              {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                            </div>
                          </div>

                          <div class="form-group row mb-1 mt-1">
                            <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="fecha_emision">Emisión</label>
                            <div class="col-md-8">
                              <input class="form-control pt-1 pr-1 pl-2 pb-1 text-select" id="fecha_emision"  type="date" name="fecha_emision" v-model="fecha_emision" placeholder="DD/MM/YYYY" >
                              {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                            </div>

                            <label class="col-md-4 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="motivo">Motivo</label>
                            <div class="col-md-6">
                              <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select text-uppercase" id="motivo"  type="text" name="motivo" v-model="motivo" placeholder="Motivo">
                              {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                            </div>
                          </div>

                          <div class="form-group row mb-1 mt-1">
                            <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="referencia">Doc refer.</label>
                            <div class="col-md-18">

                              <input type="text" class="form-control pt-1 pr-2 pl-2 pb-1 text-select text-uppercase" id="referencia" name="referencia" v-model="referencia" placeholder="Documento de regerencia"  form="frm_registro_despacho">

                              {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                            </div>
                          </div>
                          <div class="form-group row mb-1 mt-1">
                            <label class="col-md-6 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="observacion">Observación</label>
                            <div class="col-md-18">

                              <textarea class="form-control pt-1 pr-2 pl-2 pb-1 text-select text-uppercase" id="observacion" name="observacion" v-model="observacion" placeholder="Ingresar observación" rows="1" form="frm_registro_despacho">
                              </textarea>
                              {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                            </div>
                          </div>

                        {{-- </div>
                    </div> --}}
                  </div>
                  <div class="col-sm-10">
                    {{-- <div class="card card-accent-success">

                        <div class="card-body"> --}}



                              <div class="form-group row mb-1 mt-1">
                                <label class="col-md-4 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="cliente">Cliente</label>
                                <div class="col-md-20">
                                  <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select text-uppercase" id="cliente"  type="text" name="cliente"  placeholder="Ingrese nombre o número" value="" v-model="cliente.nombre" required="" form="frm_registro_despacho">
                                  {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                                </div>
                              </div>



                              <div class="form-group row mb-1 mt-1">
                                <label class="col-md-4 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="direccion">Dirección</label>
                                <div class="col-md-20">
                                  <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select text-uppercase" id="direccion"  type="text" name="direccion"  placeholder="Dirección" v-model="cliente.direccion" readonly="">
                                  {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                                </div>
                              </div>



                              <div class="form-group row mb-1 mt-1">
                                <label class="col-md-4 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="doc">Doc</label>
                                <div class="col-md-8">
                                  <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select text-uppercase" id="doc"  type="text" name="doc"  placeholder="Tipo" v-model="cliente.tipo_doc" readonly="">
                                  {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                                </div>
                                <label class="col-md-2 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="numero">#</label>
                                <div class="col-md-10">
                                  <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select" id="numero"  type="text" name="numero"  placeholder="NÚMERO" v-model="cliente.numero_doc" readonly="">
                                  {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                                </div>
                              </div>



                              <div class="form-group row mb-1 mt-1">
                                <label class="col-md-4 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="destino">Destino</label>
                                <div class="col-md-20">

                                  <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select text-uppercase" id="destino"  type="text" name="destino"  placeholder="Destino" v-model="cliente.destino_nombre" required="" form="frm_registro_despacho">
                                  {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                                </div>

                              </div>




                        {{-- </div>
                    </div> --}}
                  </div>
                  <div class="col-sm-4">
                    <div class="card card-accent-success m-0">

                        <div class="card-body p-0">
                          <p class="text-center">
                            {{-- <h5 class="text-center">CILINDROS</h3> --}}
                            <h3 class="text-center">@{{ total_cilindros }}</h1>
                            <h5 class="text-center">CILINDROS</h3>
                            <h3 class="text-center">@{{ numeral(total_cubicos).format('0,0.00') }} m3</h1>
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
                            <th>TAPA</th>
                            <th>OBSERVACIÓN</th>
                            <th>&nbsp;</th>
                          </tr>
                        </thead>
                        <tbody>

                          <tr  v-for="(cil, index) in cilindros">
                            <td>@{{ cil.serie }}</td>
                            <td>@{{ cil.propietario }}</td>
                            <td>@{{ cil.capacidad }}</td>
                            <td>@{{ cil.tapa == 1 ? 'SI' : 'NO' }}</td>
                            <td>@{{ cil.observacion }}</td>
                            <td>
                              <button class="btn btn-sm btn-default btn-accion-table btn-acciones" @click="cilindros.splice(index,1)" type="button" data-id="${d}" data-accion="eliminar" title="Quitar cilindro"><i class="fa fa-trash"></i> </button>
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
                                <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select" id="cilindro_th"  type="text" name="cilindro_th" v-model="cilindro.serie" placeholder="00000000">
                                {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                              </div>
                            </div>

                        </div>
                        <div class="col-sm-12">

                            <div class="form-group row mb-1 mt-1">
                              <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="capacidad">Capacidad</label>
                              <div class="col-md-16">
                                <div class="input-group">
                                  <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select" id="capacidad"  type="number" name="capacidad" v-model="cilindro.capacidad" placeholder="00,00" step=".01" style="height: 31px">
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

                        <div class="col-sm-12">

                            <div class="form-group row mb-1 mt-1">
                              <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="cantidad">Cantidad</label>
                              <div class="col-md-16">

                                <div class="input-group">
                                  <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select" id="cantidad"  type="number" name="cantidad" v-model="cilindro.cantidad" placeholder="00,00" step=".01" style="height: 31px">
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

                            <div class="form-group row mb-1 mt-1">
                              <label class="col-md-8 col-form-label line-height-2-1 pr-0 pt-0 pb-0 text-left" for="tapa_si">Tapa</label>
                              <div class="col-md-16">


                                  {{-- <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select" id="cantidad"  type="number" name="cantidad" v-model="cilindro.cantidad" placeholder="00,00" step=".01" style="height: 31px"> --}}

                                <div class="form-check form-check-inline ml-1 mt-1">
                                  <input class="form-check-input" id="tapa_si" type="radio" value="1" name="tapa" v-model="cilindro.tapa">
                                  <label class="form-check-label" for="tapa_si">SI</label>
                                </div>
                                <div class="form-check form-check-inline ml-1 mt-1">
                                  <input class="form-check-input" id="tapa_no" type="radio" value="0" name="tapa" v-model="cilindro.tapa">
                                  <label class="form-check-label" for="tapa_no">NO</label>
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
                                <input class="form-control pt-1 pr-2 pl-2 pb-1 text-select text-uppercase" id="propietario"  type="text" name="propietario" v-model="cilindro.propietario" placeholder="Nombre del propietario">
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

                                  <textarea class="form-control pt-1 pr-2 pl-2 pb-1 text-select text-uppercase" id="observacion_cilindro" name="observacion_cilindro" v-model="cilindro.observacion" placeholder="Ingresar observaciones">
                                  </textarea>
                                  {{-- <span class="help-block" ifs="error.propietario">Seleccione un propietario</span> --}}
                                </div>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-24">


                            <div class="form-group row mt-1 mb-1">
                              <div class="col-md-10 offset-md-4">
                                <button class="btn btn-sm btn-primary" type="submit">
                                  <i class="fa fa-dot-circle-o"></i> Agregar
                                </button>
                              </div>

                            </div>
                          </div>
                        </div>
                  </div>


            </div>
            </form>
          @endif






        </div>
        <div class="card-footer">
          <form class="form-horizontal"  @submit.prevent="frmOnSubmit_frmRegistro" id="frm_registro_despacho">
            @if (!$no_encontrado)
              <button class="btn btn-sm btn-primary" type="submit">
              <i class="fa fa-check"></i> {{ $edit ? 'Actualizar' : 'Registrar despacho' }}</button>
              @if (!$edit)
                <button class="btn btn-sm btn-danger" type="button" @click="frmOnClick_frmAnular">
                  <i class="fa fa-ban"></i> Anular</button>
              @endif
            @endif

            <a href="{{ url('home/despacho') }}" class="btn btn-sm btn-success" >
              <i class="fa fa-table"></i> Listar despacho</a>
          </form>
        </div>

      </div>
    </div>
  </template>


@endsection
@push('script')
@if (!$no_encontrado)

  <script type="text/javascript">
    const data_vue = {!! json_encode($js) !!};

  </script>
@endif

{{-- <script src="{{ url('vendors/jquery.maskedinput/dist/jquery.maskedinput.min.js') }}"></script> --}}
<script src="{{ url('js/home/despacho/registro.js') }}"></script>
  {{-- <script src="{{ url('jaen.js') }}"></script> --}}
@endpush