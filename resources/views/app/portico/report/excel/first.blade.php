<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ $title }}</title>
</head>
<body>
	<table>
		<thead>
			<tr>
				<td colspan="4">
					<strong>{{ $title }}</strong>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Sentido</strong>
				</td>
				<td colspan="3">
					<strong>{{ $sentido }}</strong>
				</td>
			</tr>
			<tr>
				<td>
					<strong>Fecha</strong>
				</td>
				<td colspan="3">
					Del <strong>{{ $start_date }}</strong> al <strong>{{ $end_date }}</strong>
				</td>
			</tr>
			<tr>
				<td colspan="4">

				</td>
			</tr>
			<tr>
				<td>
					<strong>
						Tipo de Vehiculo
					</strong>
				</td>
				<td>
					<strong>
						Fecha
					</strong>
				</td>
				<td>
					<strong>
						Tag
					</strong>
				</td>
				<td>
					<strong>
						Placa
					</strong>
				</td>
			</tr>
		</thead>
		<tbody>
			@foreach($registers as $register)
			<tr>
				<td>
					{{ $register->Tip_Vehiculo }}
				</td>
				<td>
					{{ \DateTime::createFromFormat('Y-m-d H:i:s.u', $register->fecha_hora_lectura)->format('d/m/Y H:i:s') }}
				</td>
				<td>
					{{ $register->cod_tag }}
				</td>
				<td>
					{{ $register->ID_Vehiculo }}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>