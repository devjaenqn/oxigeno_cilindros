@extends('home.cilindros')
@section('view')
  <listar></listar>
@endsection
@section('templates')
  <template id="vue_cilindros_listar">

    <div class="col-lg-24">
      <div class="card">
        <div class="card-header">
          <i class="fa fa-align-justify"></i> Cilindros - Listar
          <div class="card-header-actions">
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-24">
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="row">

                  <div class="col-sm-6">
                    <div class="form-group row">
                      <!-- <label class="col-md-3 col-form-label" for="text-input">Text Input</label> -->
                      <div class="col-md-24">
                        <input class="form-control text-select" id="txt_buscar" type="search" name="text-input" placeholder="Ingrese nombre o RUC" v-model="filtros.query" form="frm_send_filter">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-10">
                     <div class="form-group row">
                      <!-- <label class="col-md-3 col-form-label">Debe cilindros</label> -->
                      <div class="col-md-18 col-form-label">
                        <div class="form-check form-check-inline mr-1">
                          <input class="form-check-input" id="chk_perdido" type="checkbox" value="0" v-model="filtros.situacion">
                          <label class="form-check-label" for="chk_perdido">Perdido</label>
                        </div>
                        <div class="form-check form-check-inline mr-1">
                          <input class="form-check-input" id="chk_fabrica" type="checkbox" value="1" v-model="filtros.situacion">
                          <label class="form-check-label" for="chk_fabrica">Fábrica</label>
                        </div>
                        {{-- <div class="form-check form-check-inline mr-1">
                          <input class="form-check-input" id="chk_transporte" type="checkbox" value="2" v-model="filtros.situacion">
                          <label class="form-check-label" for="chk_transporte">Transporte</label>
                        </div> --}}
                        <div class="form-check form-check-inline mr-1">
                          <input class="form-check-input" id="chk_cliente" type="checkbox" value="3" v-model="filtros.situacion">
                          <label class="form-check-label" for="chk_cliente">Cliente</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="float-right">
                      <form id="frm_send_filter" @submit.prevent="fnOnSubmit_AplicarFiltro">
                      <button class="btn btn-sm btn-primary" type="submit">
                          <i class="fa fa-dot-circle-o"></i> Aplicar filtro</button>

                      <a href="{{ url('home/cilindro/create') }}" class="btn btn-sm btn-success"><i class="fa fa-dot-circle-o"></i> Agregar nuevo</a>
                      </form>
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

          <table class="table table-responsive-sm table-sm" id="tbl_cilindros">
            <thead>
              <tr>
                <th>SERIE</th>
                <th>CAPACIDAD</th>
                <th>PROPIETARIO</th>
                <th>PRESION</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
              </tr>
            </thead>
            <tbody>
             {{--  <tr v-for="cilindro in cilindros">
                <td>@{{ propietarios.razon_social }}</td>
                <td>@{{ propietarios.ruc }}</td>
                <td>@{{ propietarios.telefono }}</td>
                <td>
                  <span class="badge badge-success">Active</span>
                </td>
                <td>
                  <button class="btn btn-sm btn-default btn-accion-table" type="button"><i class="fa fa-eye"></i> </button>

                  <button class="btn btn-sm btn-default btn-accion-table" type="button" @click="goEdit(propietarios.ent_id)"><i class="fa fa-pencil"></i> </button>
                  <button class="btn btn-sm btn-default btn-accion-table" type="button"><i class="fa fa-trash"></i> </button>
                </td>
              </tr> --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
@endsection
