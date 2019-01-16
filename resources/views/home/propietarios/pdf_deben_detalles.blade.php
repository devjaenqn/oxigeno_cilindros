@extends('pdf.default')
@push('css')
  <style>
    table {

    }
  </style>
@endprepend
@section('pre-contenido')
  <table class="w-100 pb-4">
    <tbody>
      <tr>
        <td width="80">CLIENTE </td>
        <td width="3" style="padding-right:14px">:</td>
        <td>{{ $propietario->nombre }}</td>
      </tr>
      <tr>
        <td width="80">DIRECCION </td>
        <td width="3" style="padding-right:14px">:</td>
        <td>{{ $propietario->direccion }}</td>
      </tr>
      <tr>
        <td width="80">R.U.C </td>
        <td width="3" style="padding-right:14px">:</td>
        <td>{{ $propietario->numero }}</td>
      </tr>
      <tr>
        <td width="80">TELEFONO </td>
        <td width="3" style="padding-right:14px">:</td>
        <td>{{ $propietario->telefono }}</td>
      </tr>
    </tbody>
  </table>
@endsection
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