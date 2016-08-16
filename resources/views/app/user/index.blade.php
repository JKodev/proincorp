@extends('layout')

@section('css_level_plugins')
	<link href="{{ asset('assets/global/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet" type="text/css" />
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
					<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
						<i class="icon-cloud-upload"></i>
					</a>
					<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
						<i class="icon-wrench"></i>
					</a>
					<a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
						<i class="icon-trash"></i>
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<table id="table-pagination" data-toggle="table" data-url="../assets/global/plugins/bootstrap-table/data/data2.json" data-height="299" data-pagination="true" data-search="true">
					<thead>
					<tr>
						<th data-field="id" data-align="right" data-sortable="true">Usuario</th>
						<th data-field="name" data-align="center" data-sortable="true">Email</th>
						<th data-field="price" data-sortable="true" data-sorter="priceSorter">Rol</th>
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
								@foreach($user->roles() as $rol)
								{{ $rol->name }},
								@endforeach
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