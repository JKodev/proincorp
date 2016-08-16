@extends('layout')

@section('title', 'Nuevo Usuario')

@section('css_level_plugins')
	<link href="{{ asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
	<li>
		<a href="{{ route('app.settings.users.index') }}">Usuarios</a>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="{{ route('app.settings.users.create') }}">Nuevo</a>
		<i class="fa fa-circle"></i>
	</li>
@endsection

@section('content')
	<div class="page-content-inner">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-settings font-dark"></i>
					<span class="caption-subject font-dark sbold uppercase">Nuevo Usuario</span>
				</div>
			</div>
			<div class="portlet-body form">
				<form class="form-horizontal" role="form" method="post" action="{{ route('app.settings.users.store') }}">
					{{ csrf_field() }}
					<div class="form-body">
						<div class="form-group">
							<label class="col-md-3 control-label">Usuario</label>
							<div class="col-md-9">
								<div class="input-inline input-medium">
									<div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
										<input type="text" class="form-control" placeholder="Usuario" name="name">
									</div>
								</div>
								<span class="help-inline"> Nombre de usuario. </span>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Correo Electrónico</label>
							<div class="col-md-9">
								<div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
									<input type="email" class="form-control" placeholder="Correo Electrónico" name="email">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Contraseña</label>
							<div class="col-md-9">
								<div class="input-group">
									<input type="password" class="form-control" placeholder="Contraseña" name="password">
									<span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-3">Permisos</label>
							<div class="col-md-9">
								<select multiple="multiple" class="multi-select" id="permissions" name="permissions[]">
									@foreach($permissions as $permission)
										<option value="{{ $permission->id }}">{{ $permission->display_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-3 col-md-9">
								<button type="submit" class="btn green">Guardar</button>
								<a href="{{ route('app.settings.users.index') }}" class="btn default">Cancelar</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection

@section('js_level_plugins')
	<script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script>
		$(document).ready(function () {
			$('#permissions').multiSelect();
		});
	</script>
@endsection