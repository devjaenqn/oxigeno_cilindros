@extends('pdf.default')
@push('css')
  <style>
    table {

    }
  </style>
@endprepend
@section('contenido')
<table class="table table-bordered table-inverse table-hover  table-minimal" >
  <thead>
    <tr>
      <th width="80">CILINDRO</th>
      <th width="100">GUIA</th>
      <th width="80">DESDE</th>
      <th width="150">OBSERVACIÓN</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($rows as $item)
      <tr>
        <td>{{ $item['cilindro_codigo'] }}</td>
        <td>{{ $item['documento_correlativo'] }}</td>
        <td>{{ $item['fecha_emision'] }}</td>
        <td>{{ $item['destino_guia'] }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection