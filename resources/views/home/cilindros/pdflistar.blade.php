@extends('pdf.default')
@push('css')
  <style>
    table {

    }
  </style>
@endprepend
@section('pre-contenido')
@endsection
@section('contenido')
<table class="table table-bordered table-inverse table-hover  table-minimal" >
  <thead>
    <tr>
      <th width="80">DESPACHADO</th>
      <th width="100">GUIA</th>
      <th>CLIENTE</th>
      <th width="80">RECIBIDO</th>
      <th width="100">RECIBO</th>
      <th width="150">DE/OBSERVACIÓN</th>
    </tr>
  </thead>
  <tbody class="fs-30">
    @foreach ($rows as $item)
      <tr>
        <td>{{ $item['salida'] }}</td>
        <td>{{ $item['guia_correlativo'] }}</td>
        <td>{{ $item['nombre_cliente_guia'] }}</td>
        <td>{{ $item['entrada'] }}</td>
        <td>{{ $item['recibo_correlativo'] }}</td>
        <td></td>
        {{-- <td> --}}
        {{-- @if ($item->evento_entrada == 'definido') --}}
          {{ $item['salida'] }}
        {{-- @else --}}
          {{-- {{ '' }} --}}
        {{-- @endif --}}
        {{-- </td> --}}
        {{-- <td> --}}
          {{ $item['salida'] }}
          {{-- @if ($item->evento_entrada == 'definido')
            {{ $item->recibo->cliente->nombre }}
          @else
            {{ '' }}
          @endif --}}
        {{-- </td>
        <td>

        </td> --}}
      </tr>
    @endforeach
  </tbody>
</table>
@endsection