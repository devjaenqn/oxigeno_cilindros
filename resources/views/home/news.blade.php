@extends('template')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Actualizaciones</li>
@endsection
@section('contenido')
    {{-- <div class="row">
      <div class="col-lg-24">
        <div class="card">
          <div class="card-header">
            <i class="fa fa-align-justify"></i> 11/12/2018
            <div class="card-header-actions">
            </div>
          </div>
          <div class="card-body">
            <h4>MODIFICACIONES</h4>
            <ul>
                  <li>
                    <h5>Prueba</h5>
                    <img src="https://cdn4.buysellads.net/uu/1/21673/1538007875-Monday-laptop_purple_graph.png" alt="">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem, omnis voluptatum iure expedita sequi obcaecati iste dolores debitis numquam, reprehenderit eum consequuntur cum, quam nesciunt esse tenetur architecto molestiae adipisci.</p>
                  </li>
                  <li>asdad</li>
                  <li>asdad</li>
                  <li>asdad</li>
                  <li>asdad</li>
                </ul>
          </div>
        </div>
      </div>
    </div> --}}
    <div class="row">
      <div class="col-lg-24">
        <div class="card">
          <div class="card-header">
            <i class="fa fa-align-justify"></i> 07/11/2018
            <div class="card-header-actions">
            </div>
          </div>
          <div class="card-body">
            <ul>
              <li>
                <h5>INICIO DE NEWS</h5>
                <p>Aquí se mostrarán los cambios que se realicen en lo que se concrete el sistema</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
@endsection
