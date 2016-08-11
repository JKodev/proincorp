@extends('layout)

@section('content')
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12 page-404">
			<div class="number font-green"> 404 </div>
			<div class="details">
				<h3>Ups! Estás perdido.</h3>
				<p> No podemos encontrar la página que estás intentando acceder.
					<br>
					<a href="{{ route('app.init') }}"> Regresa al inicio </a> o intenta refrescando la página.
				</p>
			</div>
		</div>
	</div>
</div>
@endsection