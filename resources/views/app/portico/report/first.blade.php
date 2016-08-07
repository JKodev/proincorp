@extends('app.portico.show')

@section('title', $title)

@section('css_level_plugins')
	<link rel="stylesheet" href="http://www.amcharts.com/lib/3/plugins/export/export.css">
@endsection

@section('breadcrumb')
	@parent
	<li>
		<a href="{{ route('app.reports.portico.report', array('id' => $id, 'report_id' => $report_id)) }}">{{ $title }}</a>
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
					<div class="tools"> </div>
				</div>
				<div class="portlet-body">
					<div id="chartdiv" style="width: 100%; height: 600px; background-color: #FFFFFF;" ></div>
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
@endsection

@section('js_level_scripts')
	<script type="text/javascript">
		AmCharts.makeChart("chartdiv",
				{
					"type": "serial",
					"categoryField": "Hora",
					"rotate": true,
					"startDuration": 1,
					"theme": "default",
					"export": {
						"enabled": true
					},
					"categoryAxis": {
						"gridPosition": "start"
					},
					"trendLines": [],
					"graphs": [
						{
							"balloonText": "[[title]] a las [[Hora]]: [[value]]",
							"bullet": "round",
							"id": "AmGraph-1",
							"title": "Portico dia",
							"valueField": "Vehiculos"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1"
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
							"text": "Autos Dia"
						}
					],
					"dataProvider": [
						{
							"Hora": "0:30",
							"Vehiculos": "5"
						},
						{
							"Hora": "10:00",
							"Vehiculos": "4"
						},
						{
							"Hora": "10:30",
							"Vehiculos": "7"
						},
						{
							"Hora": "11:00",
							"Vehiculos": "11"
						},
						{
							"Hora": "11:30",
							"Vehiculos": "9"
						},
						{
							"Hora": "12:00",
							"Vehiculos": "2"
						},
						{
							"Hora": "13:00",
							"Vehiculos": "2"
						},
						{
							"Hora": "13:30",
							"Vehiculos": "1"
						},
						{
							"Hora": "14:00",
							"Vehiculos": "3"
						},
						{
							"Hora": "14:30",
							"Vehiculos": "13"
						},
						{
							"Hora": "15:00",
							"Vehiculos": "18"
						},
						{
							"Hora": "15:30",
							"Vehiculos": "9"
						},
						{
							"Hora": "16:00",
							"Vehiculos": "11"
						},
						{
							"Hora": "16:30",
							"Vehiculos": "9"
						},
						{
							"Hora": "17:00",
							"Vehiculos": "3"
						},
						{
							"Hora": "3:00",
							"Vehiculos": "2"
						},
						{
							"Hora": "4:30",
							"Vehiculos": "5"
						},
						{
							"Hora": "5:30",
							"Vehiculos": "21"
						},
						{
							"Hora": "6:00",
							"Vehiculos": "37"
						},
						{
							"Hora": "6:30",
							"Vehiculos": "145"
						},
						{
							"Hora": "7:00",
							"Vehiculos": "43"
						},
						{
							"Hora": "7:30",
							"Vehiculos": "16"
						},
						{
							"Hora": "8:00",
							"Vehiculos": "23"
						},
						{
							"Hora": "8:30",
							"Vehiculos": "14"
						},
						{
							"Hora": "9:00",
							"Vehiculos": "12"
						},
						{
							"Hora": "9:30",
							"Vehiculos": "6"
						}
					]
				}
		);
	</script>
@endsection