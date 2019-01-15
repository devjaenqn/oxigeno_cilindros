<style>
	*{
		font-size: 14px;
	}
	table.table td{
		border:1px solid black;
	}
	form .form-group {
		margin-top: 0.5em;
	}
</style>
@if ($cilindro->temporal_mode == '0')
	<h3>NORMAL</h3>
	<table class="table" style="border:1px solid black">
		<thead>
			<tr>
				<th>ID</th>
				<th>SERIE</th>
				<th>CAPACIDAD</th>
				<th>TAPA</th>
				<th>PRESIÓN</th>
				<th>PROPIETARIO</th>
				<th>SITUACION</th>
				<th>CREADO</th>
				<th>MODIFICADO</th>
				<th>CARGADO</th>
				<th>DEFECTUOSO</th>
				<th>TRASEGADO</th>
				<th>EVENTO</th>
				<th>DESPACHO_ID</th>
				<th>RECIBO_ID</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $cilindro->cil_id }}</td>
				<td>{{ $cilindro->serie }}</td>
				<td>{{ $cilindro->capacidad }}</td>
				<td>{{ $cilindro->tapa }}</td>
				<td>{{ $cilindro->presion }}</td>
				<td>{{ $cilindro->propietario_id }}</td>
				<td>{{ $cilindro->situacion }}</td>
				<td>{{ $cilindro->created_at }}</td>
				<td>{{ $cilindro->updated_at }}</td>
				<td>{{ $cilindro->cargado }}</td>
				<td>{{ $cilindro->defectuoso }}</td>
				<td>{{ $cilindro->trasegada }}</td>
				<td>{{ $cilindro->evento }}</td>
				<td>{{ $cilindro->despacho_id_salida }}</td>
				<td>{{ $cilindro->recibo_id_entrada }}</td>
			</tr>
		</tbody>
	</table>
	<div style="margin-top: 2em">
		<form action="{{ url()->current() }}" method="GET" >
			<input type="hidden" name="cilindro_id" value="{{ $cilindro->cil_id }}">
			<input type="hidden" name="accion" value="registrar">
			<legend>HACER TEMPORAL</legend>
			<table>
				<tbody>
					<tr>
						<td><label for="">SITUACION</label></td>
						<td>
							<select name="situacion" id="" class="form-control" required="required">
								<option value="0">PERDIDO</option>
								<option value="1">FABRICA</option>
								<option value="2">TRANSPORTE</option>
								<option value="3">CLIENTE</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="">CARGA</label></td>
						<td>

							<select name="cargado" id="" class="form-control" required="required">
								<option value="0">VACIO</option>
								<option value="1">CARGANDO</option>
								<option value="2">CARGADO</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="">DEFECTUOSO</label></td>
						<td>

							<select name="defectuoso" id="" class="form-control" required="required">
								<option value="0">NO</option>
								<option value="1">SI</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="">TRASEGADA</label></td>
						<td>

							<select name="trasegada" id="" class="form-control" required="required">
								<option value="0">NO</option>
								<option value="1">SI</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="">EVENTO</label></td>
						<td>

							<select name="evento" id="evento" class="form-control" required="required">
								<option value="create">CREATE</option>
								<option value="cargando">CARGANDO</option>
								<option value="cargado">CARGADO</option>
								<option value="despacho">DESPACHO</option>
								<option value="transporte">TRANPOSTE</option>
								<option value="cliente">CLIENTE</option>
								<option value="vacio">VACIO</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label for="">DESPACHO</label></td>
						<td><input type="number" name="despacho_id_salida"  class="form-control" value="0" min="0"  step="1" required="required" title="" ></td>
					</tr>
					<tr>
						<td><label for="">RECIBO</label></td>
						<td><input type="number" name="recibo_id_entrada"  class="form-control" value="0" min="0"  step="1" required="required" title="" ></td>
					</tr>
					<tr>
						<td><label for="">MOTIVO</label></td>
						<td><input type="text" name="motivo"  class="form-control"  title="" ></td>
					</tr>
					<tr>
						<td colspan="2">
							<button type="submit" class="btn btn-primary">Enviar</button>
						</td>

					</tr>
				</tbody>
			</table>


		</form>
	</div>
@else
	<h3>NORMAL</h3>
	<table class="table" style="border:1px solid black">
		<thead>
			<tr>
				<th>ID</th>
				<th>SERIE</th>
				<th>CAPACIDAD</th>
				<th>TAPA</th>
				<th>PRESIÓN</th>
				<th>PROPIETARIO</th>
				<th>SITUACION</th>
				<th>CREADO</th>
				<th>MODIFICADO</th>
				<th>CARGADO</th>
				<th>DEFECTUOSO</th>
				<th>TRASEGADO</th>
				<th>EVENTO</th>
				<th>DESPACHO_ID</th>
				<th>RECIBO_ID</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $cilindro->cil_id }}</td>
				<td>{{ $cilindro->serie }}</td>
				<td>{{ $cilindro->capacidad }}</td>
				<td>{{ $cilindro->tapa }}</td>
				<td>{{ $cilindro->presion }}</td>
				<td>{{ $cilindro->propietario_id }}</td>
				<td>{{ $temporal->situacion }}</td>
				<td>{{ $cilindro->created_at }}</td>
				<td>{{ $cilindro->updated_at }}</td>
				<td>{{ $temporal->cargado }}</td>
				<td>{{ $temporal->defectuoso }}</td>
				<td>{{ $temporal->trasegada }}</td>
				<td>{{ $temporal->evento }}</td>
				<td>{{ $temporal->despacho_id_salida }}</td>
				<td>{{ $temporal->recibo_id_entrada }}</td>
			</tr>
		</tbody>
	</table>
	<h3>TEMPORAL</h3>
	<table class="table" style="border:1px solid black">
		<thead>
			<tr>
				<th>ID</th>
				<th>SERIE</th>
				<th>CAPACIDAD</th>
				<th>TAPA</th>
				<th>PRESIÓN</th>
				<th>PROPIETARIO</th>
				<th>SITUACION</th>
				<th>CREADO</th>
				<th>MODIFICADO</th>
				<th>CARGADO</th>
				<th>DEFECTUOSO</th>
				<th>TRASEGADO</th>
				<th>EVENTO</th>
				<th>DESPACHO_ID</th>
				<th>RECIBO_ID</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $cilindro->cil_id }}</td>
				<td>{{ $cilindro->serie }}</td>
				<td>{{ $cilindro->capacidad }}</td>
				<td>{{ $cilindro->tapa }}</td>
				<td>{{ $cilindro->presion }}</td>
				<td>{{ $cilindro->propietario_id }}</td>
				<td>{{ $cilindro->situacion }}</td>
				<td>{{ $temporal->created_at }}</td>
				<td>{{ $temporal->updated_at }}</td>
				<td>{{ $cilindro->cargado }}</td>
				<td>{{ $cilindro->defectuoso }}</td>
				<td>{{ $cilindro->trasegada }}</td>
				<td>{{ $cilindro->evento }}</td>
				<td>{{ $cilindro->despacho_id_salida }}</td>
				<td>{{ $cilindro->recibo_id_entrada }}</td>
			</tr>
		</tbody>
	</table>
	<div style="margin-top: 2em">
		<form action="{{ url()->current() }}" method="GET" >
			<input type="hidden" name="cilindro_id" value="{{ $cilindro->cil_id }}">
			<input type="hidden" name="accion" value="normalizar">
			<button type="submit" class="btn btn-primary">Regresar a estado normal</button>
		</form>
	</div>
@endif
