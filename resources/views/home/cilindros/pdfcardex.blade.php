@extends('pdf.default')
@push('css')
  <style>
    table {
      background-color: red;

    }
  </style>
@endprepend
@section('contenido')
<table class="table table-bordered table-inverse table-hover">
  <thead>
    <tr>
      <th>casa</th>
      <th>nombre</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>asd</td>
      <td>asd</td>
    </tr>
    <tr>
      <td>asd</td>
      <td>asd</td>
    </tr>
    <tr>
      <td>asd</td>
      <td>asd</td>
    </tr>
    <tr>
      <td>asd</td>
      <td>asd</td>
    </tr>
    <tr>
      <td>asd</td>
      <td>asd</td>
    </tr>
  </tbody>
</table>
@endsection