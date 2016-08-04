@extends('layout')

@section('title', $title)

@section('css_level_plugins')
	<link rel="stylesheet" href="http://www.amcharts.com/lib/3/plugins/export/export.css">
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
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/export.js"></script>
@endsection

@section('js_level_scripts')
	<script type="text/javascript">
		AmCharts.makeChart("chartdiv",
				{
					"type": "pie",
					"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
					"labelRadius": 10,
					"titleField": "tipo",
					"valueField": "valor",
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
					"dataProvider": [
						@foreach($results as $result)
						{
							"tipo": "{{ $result->Tip_Vehiculo }}",
							"valor": "{{ $result->Expr1 }}"
						},
						@endforeach
					]
				}
		);
	</script>
@endsection