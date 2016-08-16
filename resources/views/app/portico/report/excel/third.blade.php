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
						Fecha y Hora
					</strong>
				</td>
				<td>
					<strong>
						Placa
					</strong>
				</td>
				<td>
					<strong>
						Grupo
					</strong>
				</td>
				<td>
					<strong>
						Empresa
					</strong>
				</td>
			</tr>
		</thead>
		<tbody>

			@foreach($registers as $register)
			<tr>
				<td>
					{{ $register->FECHA }}
				</td>
				<td>
					{{ $register['PLACA'] }}
				</td>
				<td>
					{{ \App\Models\Vehiculo::find($register['PLACA'])->Gru_Vehiculo }}
				</td>
				<td>
					{{ $register['RAZON_SOCIAL'] }}
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>