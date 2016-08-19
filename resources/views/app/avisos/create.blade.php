@extends('app.portico.index')

@section('css_level_plugins')
	<link href="{{ asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('title_content_portico', 'Nuevo Aviso')

@section('content_portico')
	<form class="form-horizontal" method="post" action="{{ route('app.reports.portico.avisos.store', array('id'=>$lector->id_lector_movimiento)) }}" role="form" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-body">
			<div class="form-group">
				<label class="col-md-4 control-label">Horario</label>
				<div class="col-md-4">
					<div class="input-icon">
						<i class="fa fa-clock-o"></i>
						<input type="text" name="start_hour" class="form-control timepicker start_hour" autocomplete="false" placeholder="Inicio">
					</div>
				</div>
				<div class="col-md-4">
					<div class="input-icon">
						<i class="fa fa-clock-o"></i>
						<input type="text" name="end_hour" class="form-control timepicker end_hour" autocomplete="false" placeholder="Fin">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Días</label>
				<div class="col-md-8">
					<div class="mt-checkbox-list">
						<label class="mt-checkbox">
							<input type="checkbox" name="monday" value="true"> Lunes
							<span></span>
						</label>
						<label class="mt-checkbox">
							<input type="checkbox" name="tuesday" value="true"> Martes
							<span></span>
						</label>
						<label class="mt-checkbox">
							<input type="checkbox" name="wednesday" value="true"> Miércoles
							<span></span>
						</label>
						<label class="mt-checkbox">
							<input type="checkbox" name="thursday" value="true"> Jueves
							<span></span>
						</label>
						<label class="mt-checkbox">
							<input type="checkbox" name="friday" value="true"> Viernes
							<span></span>
						</label>
						<label class="mt-checkbox">
							<input type="checkbox" name="saturday" value="true"> Sábado
							<span></span>
						</label>
						<label class="mt-checkbox">
							<input type="checkbox" name="sunday" value="true"> Domingo
							<span></span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label">Imágenes</label>
				<div class="col-md-8">
					<div class="input_fields_wrap">
						<div class="row" id="img-init">
							<div class="col-md-6">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
										<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
									<div>
                                <span class="btn default btn-file">
                                    <span class="fileinput-new"> Seleccionar imagen </span>
                                    <span class="fileinput-exists"> Cambiar </span>
                                    <input type="file" name="pictures[][image]">
                                </span>
										<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Quitar </a>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="control-label">Código</label>
									<input type="text" class="form-control" name="pictures[][code]">
								</div>
								<div class="form-group">
									<label class="control-label">Descripción</label>
									<input type="text" class="form-control" name="pictures[][description]">
								</div>
								<div class="form-group">
									<a href="#" class="remove_field btn red-thunderbird">
										<span class="fa fa-trash"></span>
										Eliminar
									</a>
								</div>
							</div>

						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button class="btn green-jungle add_field_button">
								<span class="fa fa-plus"></span>
								Agregar un campo
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-actions">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					<button type="submit" class="btn green">Guardar</button>
					<a href="{{ route('app.reports.portico.show', array('id'=>$lector->id_lector_movimiento)) }}" class="btn default">Cancelar</a>
				</div>
			</div>
		</div>
	</form>
@endsection

@section('js_level_plugins')
	<script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script>
	$( document ).ready(function () {
		$('.start_hour').timepicker({
			autoclose: true,
			minuteStep: 1,
			showMeridian: false
		});

		$('.end_hour').timepicker({
			autoclose: true,
			minuteStep: 1,
			showMeridian: false
		});

		$('.timepicker').parent('.input-group').on('click', '.input-group-btn', function(e){
			e.preventDefault();
			$(this).parent('.input-group').find('.timepicker').timepicker('showWidget');
		});

		$( document ).scroll(function(){
			$('.timepicker').timepicker('place');
		});

		var max_fields      = 10; //maximum input boxes allowed
		var wrapper         = $(".input_fields_wrap"); //Fields wrapper
		var add_button      = $(".add_field_button"); //Add button ID

		var x = 1; //initlal text box count
		$(add_button).click(function(e){ //on add input button click
			e.preventDefault();
			if(x < max_fields){ //max input box allowed
				x++; //text box increment
				$('#img-init').clone().attr('id', x).appendTo(wrapper);
				var img = $('#'+x);
				$(img).find('fileinput-exists').click();
				$(img).find('form-control').val('');
				//$(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
			}
		});

		$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('.row').remove(); x--;
		})
	});
	</script>
@endsection