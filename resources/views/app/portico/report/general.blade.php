@extends('app.portico.show')

@section('title', $title)

@section('css_level_plugins')
	<link rel="stylesheet" href="http://www.amcharts.com/lib/3/plugins/export/export.css">
	<link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
	@parent
	<li>
		<a href="{{ route('app.reports.portico.tags', array('id' => $id)) }}">{{ $title }}</a>
		<i class="fa fa-circle"></i>
	</li>
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
						<div class="tools"></div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-12">
								<form action="#" class="form-horizontal form-bordered">
									<div class="form-group">
										<label class="control-label col-md-3">Reporte por día</label>
										<div class="col-md-4">
											<div class="input-group input-large date-picker input-daterange"
											     data-date="{{ date('d/m/Y') }}" data-date-format="dd/mm/yyyy">
												<input type="text" value="{{ date('d/m/Y') }}" class="form-control" id="date" name="date">
											</div>
											<span class="help-block"> Seleccione una fecha </span>
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
						<div id="aqp-cv" style="width: 100%; height: 600px; background-color: #FFFFFF;"></div>
						<div id="cv-aqp" style="width: 100%; height: 600px; background-color: #FFFFFF;"></div>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>
	</div>
@endsection

@section('js_level_plugins')
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/serial.js"></script>
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/export.js"></script>
	<script type="text/javascript" src="https://www.amcharts.com/lib/3/lang/es.js"></script>
	<script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
	        type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script type="text/javascript">
		AmCharts.translations["export"]["es"] = {
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
		};

		$(document).ready(function () {
			if (jQuery().datepicker) {
				$('.date-picker').datepicker({
					rtl: App.isRTL(),
					orientation: "left",
					autoclose: true
				});
			}

			var route_aqp_cv = '{{  route('app.init') }}/service/reports/portico/general/{{ $camara->id_camara }}/{date}/0/';
			var route_cv_aqp = '{{  route('app.init') }}/service/reports/portico/general/{{ $camara->id_camara }}/{date}/1/';

			var getData = function (route) {
				var date = $('#date').val();
				if (date == '' || date === null) {
					date = '{{ date('d/m/Y') }}';
				}

				var date_unix = moment(date, "DD/MM/YYYY").unix();
				var n_route = route.replace('{date}', date_unix);

				var data = [];
				$.ajax({
					'url': n_route,
					'dataType': 'json',
					'async': false,
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
			var chart_aqp_cv = AmCharts.makeChart("aqp-cv",
				{
					"language": "es",
					"type": "serial",
					"categoryField": "hour",
					"dataDateFormat": "YYYY-MM-DD JJ:NN:SS",
					"categoryAxis": {
						"minPeriod": "ss",
						"parseDates": true
					},
					"export": {
						"enabled": true
					},
					"chartCursor": {
						"enabled": true,
						"categoryBalloonDateFormat": "JJ:NN:SS"
					},
					"chartScrollbar": {
						"enabled": true
					},
					"trendLines": [],
					"graphs": [
						{
							"bullet": "round",
							"id": "AmGraph-1",
							"title": "TAG's",
							"valueField": "tags"
						},
						{
							"bullet": "square",
							"id": "AmGraph-2",
							"title": "CÁMARAS",
							"valueField": "camaras"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": "Axis title"
						}
					],
					"allLabels": [],
					"balloon": {},
					"legend": {
						"enabled": true,
						"useGraphSettings": true
					},
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": "Reporte flujo vehicular Sentido  Arequipa - CV {{ date('d/m/Y') }}"
						}
					],
					"dataProvider": []
				}
			);

			var chart_cv_aqp = AmCharts.makeChart("cv-aqp",
					{
						"language": "es",
						"type": "serial",
						"categoryField": "hour",
						"dataDateFormat": "YYYY-MM-DD JJ:NN:SS",
						"categoryAxis": {
							"minPeriod": "ss",
							"parseDates": true
						},
						"export": {
							"enabled": true
						},
						"chartCursor": {
							"enabled": true,
							"categoryBalloonDateFormat": "JJ:NN:SS"
						},
						"chartScrollbar": {
							"enabled": true
						},
						"trendLines": [],
						"graphs": [
							{
								"bullet": "round",
								"id": "AmGraph-1",
								"title": "TAG's",
								"valueField": "tags"
							},
							{
								"bullet": "square",
								"id": "AmGraph-2",
								"title": "CÁMARAS",
								"valueField": "camaras"
							}
						],
						"guides": [],
						"valueAxes": [
							{
								"id": "ValueAxis-1",
								"title": "Axis title"
							}
						],
						"allLabels": [],
						"balloon": {},
						"legend": {
							"enabled": true,
							"useGraphSettings": true
						},
						"titles": [
							{
								"id": "Title-1",
								"size": 15,
								"text": "Reporte flujo vehicular Sentido CV - Arequipa {{ date('d/m/Y') }}"
							}
						],
						"dataProvider": []
					}
			);

			chart_aqp_cv.dataProvider = getData(route_aqp_cv);
			chart_aqp_cv.validateData();
			chart_cv_aqp.dataProvider = getData(route_cv_aqp);
			chart_cv_aqp.validateData();

			var initChartFunct = function () {
				chart_aqp_cv.dataProvider = getData(route_aqp_cv);
				chart_cv_aqp.dataProvider = getData(route_cv_aqp);
				toastr.info("Creando Gráfico con los datos...");
				chart_aqp_cv.titles = [];
				chart_cv_aqp.titles = [];
				var title_aqp_cv = "Reporte flujo vehicular Sentido  Arequipa - CV " + $("#date").val();
				var title_cv_aqp = "Reporte flujo vehicular Sentido  CV - Arequipa " + $("#date").val();
				chart_aqp_cv.addTitle(title_aqp_cv, 15);
				chart_cv_aqp.addTitle(title_cv_aqp, 15);
				chart_aqp_cv.validateData();
				chart_cv_aqp.validateData();
				chart_aqp_cv.animateAgain();
				chart_cv_aqp.animateAgain();
			};

			//initChartFunct();

			$('#show-report').on("click", function () {
				toastr.info("Obteniendo información del servidor. Un momento por favor.");
				setTimeout(function () {
					initChartFunct();
				}, 1000);
			});
		});

	</script>
@endsection