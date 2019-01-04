@extends('home.despacho')
@section('view')
  <listar></listar>
@endsection
@section('templates')
  <template id="vue_produccion_listar">

    <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Despacho - Listar
          <div class="card-header-actions">
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-24">
              <form class="form-horizontal" @submit.prevent="onSubmit_frmAplicarFiltro()">
                <div class="row">

                  <div class="col-sm-8">
                    <div class="form-group row">
                      <!-- <label class="col-md-3 col-form-label" for="text-input">Text Input</label> -->
                      <div class="col-md-24">
                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Número, cilindro, cliente, destino" v-model="filtros.query">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-10">
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
                      <a href="{{ url('home/despacho/create') }}" class="btn btn-sm btn-success"><i class="fa fa-dot-circle-o"></i> Agregar nuevo</a>
                    </div>


                  </div>
                </div>
               <!--  <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="email-input">Email Input</label>
                  <div class="col-md-9">
                    <input class="form-control" id="email-input" type="email" name="email-input" placeholder="Enter Email">
                    <span class="help-block">Please enter your email</span>
                  </div>
                </div> -->


              <!--   <div class="form-group row">
                  <label class="col-md-3 col-form-label" for="select1">Select</label>
                  <div class="col-md-9">
                    <select class="form-control" id="select1" name="select1">
                      <option value="0">Please select</option>
                      <option value="1">Option #1</option>
                      <option value="2">Option #2</option>
                      <option value="3">Option #3</option>
                    </select>
                  </div>
                </div> -->




              </form>
            </div>

          </div>

          <div class="row">
            <div class="col-sm-24">
              {{-- <div class="table-responsive"> --}}
                <table class="table table-responsive-sm table-sm table-minimal" id="tbl_despacho" style="width: 100%">
                  <thead>
                    <tr>
                      <th width="50px">FECHA</th>
                      {{-- <th></th> --}}
                      {{-- <th width="40px">NEGOCIO</th> --}}
                      {{-- <th width="30px">SERIE</th> --}}
                      <th width="170px">GUÍA</th>
                      <th>CLIENTE</th>
                      <th>DESTINO</th>
                      <th width="25px">CIL.</th>
                      <th width="20px">M3</th>
                      <th width="60px">ACCIONES</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              {{-- </div> --}}
            </div>
          </div>


        </div>
      </div>

      <div class="modal fade" id="modRegistroLlegada" tabindex="-1" role="dialog" aria-labelledby="horaLlegada" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">@{{ llegada_salida.titulo }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="fnOnSubmit_registrarLlegada" ref="frmRegistrarLlegada">
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-24">
                    <div class="form-group row">
                      <label class="col-md-6 col-form-label" for="guia">Guía</label>
                      <div class="col-md-18">
                        <p class="form-control-static">@{{ llegada_salida.documento }}</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-24">
                    <div class="form-group row">
                      <label class="col-md-6 col-form-label" for="fecha_llegada">Fecha</label>
                      <div class="col-md-18">
                        <input class="form-control text-select" ref="fecha_llegada" id="fecha_llegada" ref="fecha_llegada" type="date" name="nombre"  placeholder="00:00" v-model="llegada_salida.fecha" :disabled="sending">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-24">
                    <div class="form-group row">
                      <label class="col-md-6 col-form-label" for="hora_llegada">Hora</label>
                      <div class="col-md-18">
                        <input class="form-control text-select" id="hora_llegada" ref="hora_llegada" type="time" name="nombre"  placeholder="00:00" v-model="llegada_salida.hora" :disabled="sending">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" :disabled="sending">Registrar</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </template>
@endsection


@push('script')
<script src="{{ url('js/home/despacho/listar.js') }}"></script>
  {{-- <script src="{{ url('jaen.js') }}"></script> --}}
@endpush