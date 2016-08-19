<?php

namespace App\Http\Controllers;

use App\Helpers\ReportHelper;
use App\Helpers\SerializeHelper;
use App\Models\Advertisement;
use App\Models\Lector;
use DB;
use Excel;
use Illuminate\Http\Request;
use App\Helpers\CamaraStaticHelper;
use App\Http\Requests;
use App\Models\Camara;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class PorticoController extends Controller
{
	/**
	 * @var array
	 */
	private $colors = ["green-jungle", "blue-sharp", "red-thunderbird", "yellow-gold", "purple-seance", "blue-ebonyclay", "green-turquoise", "grey-salsa", "red-sunglo", "yellow-soft", "purple-medium"];

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index()
	{
		$lectores = Lector::orderBy('dsc_lector_movimiento')->get();
		return view('app.portico.index', array(
			'lectores' => $lectores,
			'colors' => $this->colors
		));
	}

	/**
	 * @param $id integer
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show($id)
	{
		$totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
		$lectores = Lector::orderBy('dsc_lector_movimiento')->get();
		$lector = Lector::where('id_lector_movimiento', $id)->first();

		$advertisements = Advertisement::where('lector_id', $id)
			->orderBy('start_hour', 'asc')
			->orderBy('end_hour', 'asc')
			->get();

		return view('app.portico.show', array(
			'lector' => $lector,
			'lectores' => $lectores,
			'colors' => $this->colors,
			'totals' => $totals,
			'advertisements' => $advertisements
		));

	}

	/**
	 * @param $id integer
	 * @param $report_id integer
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function report($id, $report_id)
	{
		$totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
		$lector = Lector::find($id);
		$lectores = Lector::orderBy('dsc_lector_movimiento')->get();
		$view = '';
		$variables = array(
			'title' => '',
			'id' => $id,
			'report_id' => $report_id,
			'lector' => $lector,
			'lectores' => $lectores,
			'colors' => $this->colors,
			'totals' => $totals
		);

		switch ($report_id) {
			case "1":
				$view = 'app.portico.report.first';
				$variables['title'] = "Autos día";
				break;
			case "2":
				$variables['title'] = "Tipo de Vehículo";
				$view = 'app.portico.report.second';
				break;
			case "3":
				$view = 'app.portico.report.third';
				$variables['title'] = "Tipo de Vehículo Empresa";
				break;
			case "4":
				return view('app.portico.report.fourth');
				break;
			default:
				break;
		}

		return view($view, $variables);
	}

	/**
	 * @param $id integer
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function tags($id)
	{
		$totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
		$camara = DB::connection('sqlsrv')
			->table('TB_LECTOR_CAMARA')
			->where('id_lector_movimiento', $id)
			->first();
		$lector = Lector::find($id);
		$lectores = Lector::orderBy('dsc_lector_movimiento')->get();
		return view('app.portico.report.tags', array(
			'title' => 'Reporte por Tags',
			'id' => $id,
			'lector' => $lector,
			'lectores' => $lectores,
			'colors' => $this->colors,
			'camara' => $camara,
			'totals' => $totals
		));
	}

	/**
	 * @param $id integer
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function camaras($id)
	{
		$totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
		$camara = DB::connection('sqlsrv')
			->table('TB_LECTOR_CAMARA')
			->where('id_lector_movimiento', $id)
			->first();
		$lector = Lector::find($id);
		$lectores = Lector::orderBy('dsc_lector_movimiento')->get();
		return view('app.portico.report.camaras', array(
			'title' => 'Reporte por Cámaras',
			'id' => $id,
			'lector' => $lector,
			'lectores' => $lectores,
			'colors' => $this->colors,
			'camara' => $camara,
			'totals' => $totals
		));
	}

	/**
	 * @param $id integer
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function general($id)
	{
		$totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
		$camara = DB::connection('sqlsrv')
			->table('TB_LECTOR_CAMARA')
			->where('id_lector_movimiento', $id)
			->first();
		$lector = Lector::find($id);
		$lectores = Lector::orderBy('dsc_lector_movimiento')->get();
		return view('app.portico.report.general', array(
			'title' => 'Reporte General',
			'id' => $id,
			'lector' => $lector,
			'lectores' => $lectores,
			'colors' => $this->colors,
			'camara' => $camara,
			'totals' => $totals
		));
	}

	/**
	 * @param $id integer
	 * @param $start_date integer unix time
	 * @param $end_date integer unix time
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function serviceTipoVehiculoPorcentual($id, $start_date, $end_date)
	{
		$s_date = date("Y-m-d 00:00:00", $start_date);
		$e_date = date("Y-m-d 23:59:59", $end_date);
		$data = ReportHelper::tipo_vehiculo_porcentual($id, $s_date, $e_date);
		$serialize = SerializeHelper::fromArray($data, array("Gru_Vehiculo", "sum"));

		return response()->json($serialize);
	}

	public function serviceTipoVehiculoPorcentualExcel(Request $request, $id)
	{
		$start_date = $request->start_date;
		$end_date = $request->end_date;

		$s_date = date("Y-m-d 00:00:00", $start_date);
		$e_date = date("Y-m-d 23:59:59", $end_date);

		$title = 'Reporte Tipo de Vehiculo';
		$lector = Lector::find($id);
		$data = ReportHelper::tipoVehiculoPorcentualExcel($id, $s_date, $e_date);

		$parameters = array(
			'title' => $title,
			'registers' => $data,
			'start_date' => $s_date,
			'end_date' => $e_date,
			'sentido' => preg_replace('/(\d+)\_(\d+)/', " ", $lector->dsc_lector_movimiento)
		);

		Excel::create($title, function (LaravelExcelWriter $excel) use ($parameters) {
			$excel->sheet('Tipo de Vehiculo', function (LaravelExcelWorksheet $sheet) use ($parameters) {
				$sheet->loadView('app.portico.report.excel.second', $parameters);
			});
		})->export('xlsx');
	}

	/**
	 * @param Request $request
	 * @param $id integer
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function serviceTipoVehiculoEmpresa(Request $request, $id)
	{
		$length = $request->length;
		$start = $request->start;
		$draw = $request->draw;
		$parameters = $request->filters;
		$order = $request->order;

		$data = ReportHelper::tipo_vehiculo_empresa($id, $length, $start, $draw, $parameters, $order);

		return response()->json($data);
	}

	public function serviceTipoVehiculoEmpresaExcel(Request $request, $id)
	{
		$lector = Lector::find($id);

		$parameters = array(
			'date_from' => (!empty($request->date_from)) ? $request->date_from : date('01/01/Y'),
			'date_to' => (!empty($request->date_to)) ? $request->date_to : date('d/m/Y'),
			'empresa' => $request->empresa,
			'placa' => $request->placa
		);

		$order = array(
			array(
				'column' => '0',
				'dir' => 'desc'
			)
		);

		$start_date = \DateTime::createFromFormat("d/m/Y", $parameters['date_from']);
		$end_date = \DateTime::createFromFormat("d/m/Y", $parameters['date_to']);

		$info = ReportHelper::tipoVehiculoEmpresaQuery($id, 0, -1, $parameters, $order);

		$data = array(
			'title' => 'Tipos Vehículos Empresa',
			'registers' => $info['results'],
			'start_date' => $start_date->format('d/m/Y 00:00:00'),
			'end_date' => $end_date->format('d/m/Y 00:00:00'),
			'sentido' => preg_replace('/(\d+)\_(\d+)/', " ", $lector->dsc_lector_movimiento)
		);

		Excel::create($data['title'], function (LaravelExcelWriter $excel) use ($data) {
			$excel->sheet('Vehiculos Dia', function (LaravelExcelWorksheet $sheet) use ($data) {
				$sheet->loadView('app.portico.report.excel.third', $data);
			});
		})->export('xlsx');
	}

	/**
	 * @param $id integer
	 * @param $date integer unix time
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function serviceVehiculosDia($id, $date)
	{
		$f_date = date("d/m/Y", $date);
		$data = ReportHelper::autos_dia($id, $f_date);

		return response()->json($data);
	}

	public function serviceVehiculosDiaExcel(Request $request, $id)
	{
		$lector = Lector::find($id);
		$date = date("d/m/Y", $request->date);

		$parameters = array(
			'title' => 'Vehiculos por día',
			'registers' => ReportHelper::autosDia($id, $date),
			'start_date' => $date . ' 00:00:00',
			'end_date' => $date . ' 23:59:59',
			'sentido' => preg_replace('/(\d+)\_(\d+)/', " ", $lector->dsc_lector_movimiento)
		);

		Excel::create($parameters['title'], function (LaravelExcelWriter $excel) use ($parameters) {
			$excel->sheet('Vehiculos Dia', function (LaravelExcelWorksheet $sheet) use ($parameters) {
				$sheet->loadView('app.portico.report.excel.first', $parameters);
			});
		})->export('xlsx');
	}

	/**
	 * @param $id integer
	 * @param $date integer unix time
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function serviceTags($id, $date)
	{
		$f_date = date("d/m/Y", $date);
		$data = ReportHelper::informe_tags($id, $f_date);

		$serialize = SerializeHelper::parseToChart($data);

		return response()->json($serialize);
	}

	/**
	 * @param $id integer
	 * @param $date integer unix time
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function serviceCamaras($id, $date)
	{
		$f_date = date("d/m/Y", $date);
		$data = ReportHelper::informe_camaras($id, $f_date);

		$serialize = SerializeHelper::parseToChart($data);

		return response()->json($serialize);
	}

	/**
	 * @param $id integer
	 * @param $date integer unix time
	 * @param $direction integer
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function serviceGeneral($id, $date, $direction)
	{
		$dir = 'Arequipa - CV';
		if ($direction == 1) {
			$dir = 'CV - Arequipa';
		}
		$f_date = date("d/m/Y", $date);
		$data = ReportHelper::informe_general($id, $f_date);
		//dd($data);
		$serialize = SerializeHelper::parseGeneralToChart($data, $dir);

		return response()->json($serialize);
	}
}
