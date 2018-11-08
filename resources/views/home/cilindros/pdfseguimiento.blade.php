@extends('pdf.default')
@push('css')
  <style>
    table {
      background-color: red;

    }
  </style>
@endprepend
@section('contenido')
<table class="table table-bordered table-inverse table-hover table-pdf">
  <thead>
    <tr>
      <th>DESPACHADO</th>
      <th>GUIA</th>
      <th>CLIENTE</th>
      <th>RECIBIDO</th>
      <th>RECIBO</th>
      <th>DE/OBSERVACIÓN</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($detalles_cilindro as $item)
      <tr>
        <td>{{ $item['cilindro_id'] }}</td>
        <td>{{ $item['cilindro_id'] }}</td>
        <td>{{ $item['evento'] }}</td>
        <td>{{ $item['descripcion'] }}</td>
        <td>{{ $item['cilindro_id'] }}</td>
        <td>{{ $item['fecha'] }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
@endsection