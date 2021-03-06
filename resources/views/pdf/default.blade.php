<!DOCTYPE html>

<html lang="en">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

  @include('pdf.css.pdf')
  @include('pdf.css.custom')
    <style type="text/css">
      @page { margin: 10pt 10pt !important; }
      body {
        background-color: white;
      }
      table.table-pdf{

      }
      table.table-pdf tbody  tr  td, table.table-pdf thead  tr  th {
        /*padding: 2pt 4pt !important;*/
      }
    </style>
    @stack('css')
  </head>
  <body class="">
    <div class="app-body">
      <main class="main">
        <table style="width: 100%">
          <tbody>
            <tr>
              <td>{{ $negocio->nombre }}</td>
              <td></td>
            </tr>
            <tr>
              <td>{{ $negocio->direccion }}</td>
              <td></td>
            </tr>
            <tr>
              <td>{{ $negocio->telefono }}</td>
              <td></td>
            </tr>
          </tbody>
        </table>
        <br>
        <table style="width: 100%">
          <thead>
            <tr>
              <th class="text-center">
                @if (isset($titulo))  
                  {{$titulo}}
                @endif
              </th>
            </tr>
          </thead>
        </table>
        <br>

        <div class="container-fluid">
          <div class="animated">
            @section('pre-contenido')
              <h3>SIN CONTENIDO</h3>
            @show
          </div>  
          <div class="animated fadeIn">
            <!-- CONTENIDO -->
            @section('contenido')
              <h1>SIN CONTENIDO</h1>
            @show
          </div>
        </div>
      </main>
    </div>
    @include('includes/footer')
  </body>
</html>