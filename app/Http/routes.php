<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', [
	'as'    =>  'app.init',
	'uses'  =>  function() {
		return view('welcome');
	}
]);

Route::group([
	'prefix'	=>	'app'
	], function () {

		Route::get('/', [
			'as'	=>	'app.dashboard',
			'uses'	=>	'DashboardController@index'
		]);

		Route::group([
			'prefix'	=>	'/reports'
			], function () {

				Route::group([
					'prefix'	=>	'portico'
					], function () {
						
						Route::get('/', [
							'as'	=>	'app.reports.portico.index',
							'uses'	=>	'PorticoController@index'
						]);

                        Route::get('/{id}', [
                            'as'    =>  'app.reports.portico.show',
                            'uses'  =>  'PorticoController@show'
                        ]);

						Route::get('/{id}/report/{report_id}', [
							'as'    =>  'app.reports.portico.report',
							'uses'  =>  'PorticoController@report'
						]);
				});

				Route::group([
					'prefix' 	=>	'empresa'
					], function() {
				    	
				    	Route::get('/', [
				    		'as'	=>	'app.reports.empresa.index',
				    		'uses'	=>	'EmpresaController@index'
				    	]);

						Route::get('/{id}/report/', [
							'as'    =>  'app.reports.empresa.report',
							'uses'  =>  'EmpresaController@report'
						]);
				});

				Route::group([
					'prefix' 	=>	'camaras'
					], function() {
				    	
				    	Route::get('/', [
				    		'as'	=>	'app.reports.camaras.index',
				    		'uses'	=>	'CamarasController@index'
				    	]);
				});

				Route::group([
					'prefix' 	=>	'vehiculo'
					], function() {
				    	
				    	Route::get('/', [
				    		'as'	=>	'app.reports.vehiculo.index',
				    		'uses'	=>	'VehiculoController@index'
				    	]);
				});
		});
});

Route::group([
	'prefix'    =>  'service'
], function () {

	Route::group([
		'prefix'    =>  'reports'
	], function () {
		Route::group([
			'prefix'    =>  'portico'
		], function () {

			Route::get('/porcentual/{id}/{start_date}/{end_date}/', [
				'as'    =>  'service.reports.portico.tipos-vehiculos.porcentual',
				'uses'  =>  'PorticoController@serviceTipoVehiculoPorcentual'
			]);

			Route::post('/empresa/{id}/', [
				'as'    =>  'service.reports.portico.tipos-vehiculos.empresa',
				'uses'  =>  'PorticoController@serviceTipoVehiculoEmpresa'
			]);
		});
	});
});
