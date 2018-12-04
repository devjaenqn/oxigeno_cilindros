 @extends('home.produccion')
@section('view')
  <listar></listar>
@endsection
@section('templates')
  <template id="vue_produccion_listar">

    <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Producción - Listar
          <div class="card-header-actions">
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-24">
              <form class="form-horizontal" @submit.prevent="onSubmit_frmAplicarFiltro">
                <div class="row">

                  <div class="col-sm-8">
                    <div class="form-group row">
                      <!-- <label class="col-md-3 col-form-label" for="text-input">Text Input</label> -->
                      <div class="col-md-24">
                        <input class="form-control" id="text-input" type="text" name="text-input" placeholder="Lote, cilindro, operador" v-model="filtros.query">
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
                        <a href="{{ url('home/produccion/create') }}" class="btn btn-sm btn-success"><i class="fa fa-dot-circle-o"></i> Agregar nuevo</a>
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
                        <table class="table table-responsive-sm table-sm table-minimal" id="tbl_produccion" style="width: 100%">
            <thead>
              <tr>
                <th>FECHA</th>
                <th>SISTEMA</th>
                <th>LOTE</th>
                <th>ENTRADA</th>
                <th>SALIDA</th>
                <th>CILINDROS</th>
                <th>LIBRAS</th>
                <th>OPERADOR</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody>
              {{-- <tr>
                <td>.razon_social</td>
                <td>.ruc</td>
                <td>.telefono</td>
                <td>.telefono</td>
                <td>.telefono</td>
                <td>.telefono</td>
                <td>.telefono</td>
                <td>.telefono</td>
                <td>
                  <span class="badge badge-success">Active</span>
                </td>
                <td>
                  <button class="btn btn-sm btn-default btn-accion-table" type="button"><i class="fa fa-eye"></i> </button>

                  <button class="btn btn-sm btn-default btn-accion-table" type="button"><i class="fa fa-pencil"></i> </button>
                  <button class="btn btn-sm btn-default btn-accion-table" type="button"><i class="fa fa-trash"></i> </button>
                </td>
              </tr> --}}
            </tbody>
          </table>
            </div>
          </div>


        </div>
      </div>
    </div>
  </template>
@endsection


@push('script')
<script src="{{ url('js/home/produccion/listar.js') }}"></script>
  {{-- <script src="{{ url('jaen.js') }}"></script> --}}
@endpush