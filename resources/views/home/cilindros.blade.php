@extends('template')
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Cilindros</li>
@endsection
@push('css')
  <link rel=stylesheet href="{{ url('vendors/datatable/datatables.css') }}">
@endprepend
@section('contenido')
    <div class="row container_vue" id="vue_cilindros">
      @section('view')
        <h1>SIN VIEW</h1>
      @show
    </div>
@endsection
@push('script')
  <script type="text/javascript">
    var cilindro_url = "{{ request()->filled('c') ? request('c') : '' }}";
  </script>
  <script src="{{ url('vendors/datatable/datatables.js') }}"></script>
  <script src="{{ url('js/home/cilindros/colores_cilindro.js') }}"></script>
  <script src="{{ url('js/home/cilindros/cilindros.js') }}"></script>
  {{-- @stack('script') --}}
{{-- @endprepend --}}
@endpush