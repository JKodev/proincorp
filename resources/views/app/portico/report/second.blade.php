@extends('layout')

@section('title', $title)

@section('css_level_plugins')
	<link rel="stylesheet" href="http://www.amcharts.com/lib/3/plugins/export/export.css">
	<link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<div class="page-content-inner">
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-settings font-dark"></i>
							<span class="caption-subject bold uppercase">{{ $title }}</span>
						</div>
						<div class="tools">

						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-12">
								<form action="#" class="form-horizontal form-bordered">
									<div class="form-group">
										<label class="control-label col-md-3">Reporte por Fechas</label>
										<div class="col-md-4">
											<div class="input-group input-large date-picker input-daterange"
											     data-date="{{ date('d/m/Y') }}" data-date-format="dd/mm/yyyy">
												<input type="text" value="{{ date('d/m/Y') }}" class="form-control" id="from" name="from">
												<span class="input-group-addon"> a </span>
												<input type="text" value="{{ date('d/m/Y') }}" class="form-control" id="to" name="to">
											</div>
											<span class="help-block"> Seleccione rango de fechas </span>
										</div>
										<div class="col-md-3">
											<button class="btn btn-success" id="show-report" type="button">
												Mostrar Reporte
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div id="chartdiv" style="width: 100%; height: 600px; background-color: #FFFFFF;"></div>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>
	</div>
@endsection

@section('js_level_plugins')
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/export.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/lang/es.js"></script>
	<script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script src="{{ asset('assets/pages/scripts/components-date-time-pickers.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		AmCharts.translations[ "export" ][ "es" ] = {
			"fallback.save.text": "CTRL + C para copiar los datos en el portapapeles.",
			"fallback.save.image": "Click Derecho -> Guardar imagen como... para guardar la imagen.",

			"capturing.delayed.menu.label": "@{{duration}}",
			"capturing.delayed.menu.title": "Click a Cancelar",

			"menu.label.print": "Imprimir",
			"menu.label.undo": "Deshacer",
			"menu.label.redo": "Rehacer",
			"menu.label.cancel": "Cancelar",

			"menu.label.save.image": "Descargar como...",
			"menu.label.save.data": "Guardar como...",

			"menu.label.draw": "Anotar ...",
			"menu.label.draw.change": "Cambiar ...",
			"menu.label.draw.add": "Agregar ...",
			"menu.label.draw.shapes": "Forma ...",
			"menu.label.draw.colors": "Color ...",
			"menu.label.draw.widths": "Tamaño ...",
			"menu.label.draw.opacities": "Opacidad ...",
			"menu.label.draw.text": "Texto",

			"menu.label.draw.modes": "Modo ...",
			"menu.label.draw.modes.pencil": "Lapiz",
			"menu.label.draw.modes.line": "Linea",
			"menu.label.draw.modes.arrow": "Flecha",

			"label.saved.from": "Saved from: "
		}
		$(document).ready(function () {
			if (jQuery().datepicker) {
				$('.date-picker').datepicker({
					rtl: App.isRTL(),
					orientation: "left",
					autoclose: true
				});
			}

			var route = '{{  route('app.init') }}/service/reports/portico/{{ $id }}/{start_date}/{end_date}/';
			var getData = function () {
				var start = $('#from').val();
				var end = $('#to').val();
				if (start == '' || start === null) {
					start = '{{ date('d/m/Y') }}';
				}
				if (end == '' || end === null) {
					end = '{{ date('d/m/Y') }}';
				}

				var start_unix = moment(start, "DD/MM/YYYY").unix();
				var end_unix = moment(end, "DD/MM/YYYY").unix();
				var n_route = route.replace('{start_date}', start_unix);
				n_route = n_route.replace('{end_date}', end_unix);

				var data = [];
				$.ajax({
					'url': n_route,
					'dataType': 'json',
					'async': false,
					'beforeSend': function () {
						toastr.info("Obteniendo información del servidor...");
					},
					'success': function (response) {
						if (response.length == 0) {
							toastr.warning("No hay datos para esta fecha, pruebe con una fecha distinta.", "No se encontraron datos.");
						} else {
							toastr.success("Se ha cargado la información de forma correcta.", "Exito");
						}
						data = response;
					},
					'error': function (error) {
						toastr.error("No se ha podido obtener la información desde el servidor.<br>Intentelo en unos minutos.", "Error de petición.");
					}
				});

				return data;
			};

			var chart = AmCharts.makeChart("chartdiv",
					{
						"language": "es",
						"type": "pie",
						"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
						"labelRadius": 10,
						"titleField": "Tip_Vehiculo",
						"valueField": "sum",
						"groupPercent": 5,
						"export": {
							"enabled": true
						},
						"allLabels": [],
						"balloon": {},
						"legend": {
							"enabled": true,
							"align": "center",
							"markerType": "circle"
						},
						"titles": [],

						"dataProvider": []
					}
			);
			chart.dataProvider = getData();
			chart.validateData();

			var initChartFunct = function () {
				chart.dataProvider = getData();
				toastr.info("Creando Gráfico con los datos...");
				chart.titles = [];
				var title = "Del " + $("#from").val() + " al " + $("#to").val();
				chart.addTitle(title);
				chart.validateData();
				chart.animateAgain();
			};

			//initChartFunct();

			$('#show-report').on("click", function () {
				initChartFunct();
			});
		});
	</script>
@endsection