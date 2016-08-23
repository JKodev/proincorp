@extends('layout')

@section('title', 'Usuarios')

@section('css_level_plugins')
	<link href="{{ asset('assets/global/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
	<li>
		<a href="{{ route('app.settings.users.index') }}">Usuarios</a>
		<i class="fa fa-circle"></i>
	</li>
@endsection

@section('content')
<div class="page-content-inner">
	<div class="mt-bootstrap-tables">
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-social-dribbble font-green hide"></i>
					<span class="caption-subject font-dark bold uppercase">Usuarios</span>
				</div>
				<div class="actions">
					<a class="btn" href="{{ route('app.settings.users.create') }}">
						<i class="icon-user-follow "></i>
						Nuevo Usuario
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<table id="table-pagination" data-toggle="table" data-height="299" data-pagination="true" data-search="true">
					<thead>
					<tr>
						<th data-field="id" data-align="right" data-sortable="true">Usuario</th>
						<th data-field="name" data-align="center" data-sortable="true">Email</th>
						<th data-field="price" data-sortable="true" data-sorter="priceSorter">Rol</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					@foreach($users as $user)
						<tr>
							<td>
								{{ $user->name }}
							</td>
							<td>
								{{ $user->email }}
							</td>
							<td>
								@foreach($user->roles()->get() as $rol)
									@foreach($rol->perms()->get() as $permission)
										{{ $permission->display_name }},
									@endforeach
								@endforeach
							</td>
							<td>
								<a href="{{ route('app.settings.users.edit', array('id'=>$user->id)) }}" class="btn green-jungle">
									<span class="fa fa-edit"></span>
									Editar
								</a>
								<a href="{{ route('app.settings.users.destroy', array('id'=>$user->id)) }}" type="submit" class="btn red-thunderbird">
									<span class="fa fa-trash"></span>
									Eliminar
								</a>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js_level_plugins')
	<script src="{{ asset('assets/global/plugins/bootstrap-table/bootstrap-table.min.js') }}" type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script src="{{ asset('assets/pages/scripts/table-bootstrap.min.js') }}" type="text/javascript"></script>
@endsection