<!DOCTYPE html>
<html>
<head>
  <title>PROPIETARIOS DE BALANCE</title>
  <link href="{{ url('css/app.css') }}" rel="stylesheet">
  
</head>
<body>
  <div class="container">
    <div class="row">
      <h2>PROPIETARIOS</h2>
    </div>
    <div class="row">
      <div class="col-sm-24">
        <table id="tbl_propietarios" style="width: 100%">
          <thead>
            <th>RAZON SOCIAL</th>
            <th>RUC/NUMERO</th>
            <th>DIRECCION</th>
            <th>TELEFONO</th>
            <th>CORREO</th>
          </thead>
            
            
          <tbody>
            
          </tbody>
        </table>
        
      </div>
    </div> 
  </div>
<script src="{{ url('vendors/jquery/dist/jquery.js') }}"></script>
<script src="{{ url('vendors/bootstrap/dist/js/bootstrap.js') }}"></script>
<script src="{{ url('vendors/datatable/datatables.js') }}"></script>
<script type="text/javascript">
  var data = {!!json_encode($propietarios)!!};
  $(document).ready( function () {
    $('#tbl_propietarios').DataTable({
      data: data,
      columns: [
        { data: 'cli_razon_social' },
        { data: 'cli_ruc' },
        { data: 'cli_direccion' },
        { data: 'cli_telefono' },
        { data: 'cli_correo' }
      ] 
    });
  } );

</script>
</body>
</html>

