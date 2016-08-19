<?php

namespace App\Http\Controllers;

use App\Helpers\ReportHelper;
use App\Models\Advertisement;
use App\Models\AdvertisementPictures;
use App\Models\Lector;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\UploadedFile;
use Storage;

class AdvertisementController extends Controller
{
	/** @var array $colors */
	private $colors = ["green-jungle", "blue-sharp", "red-thunderbird", "yellow-gold", "purple-seance", "blue-ebonyclay", "green-turquoise", "grey-salsa", "red-sunglo", "yellow-soft", "purple-medium"];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
	    $totals = ReportHelper::totalAllReports($id, date('d/m/Y 00:00:00'), date('d/m/Y 23:59:59'));
	    $lectores = Lector::orderBy('dsc_lector_movimiento')->get();
	    $lector = Lector::where('id_lector_movimiento', $id)->first();

	    $advertisements = Advertisement::where('lector_id', $id)
		    ->orderBy('start_hour', 'asc')
		    ->orderBy('end_hour', 'asc')
		    ->get();

	    return view('app.avisos.create')->with([
		    'lector' => $lector,
		    'lectores' => $lectores,
		    'colors' => $this->colors,
		    'totals' => $totals,
		    'advertisements' => $advertisements
	    ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
    	dd($request->all());
		$start_hour = date('H:i:s', strtotime($request->input('start_hour', '00:00')));
	    $end_hour = date('H:i:s', strtotime($request->input('end_hour', '00:00')));
	    $monday = $request->input('monday', false);
	    $tuesday = $request->input('tuesday', false);
	    $wednesday = $request->input('wednesday', false);
	    $thursday = $request->input('thursday', false);
	    $friday = $request->input('friday', false);
	    $saturday = $request->input('saturday', false);
	    $sunday = $request->input('sunday', false);
	    $codes = $request->input('pictures', array());
	    $pictures = $request->file('pictures');

	    $advertisement = new Advertisement();
	    $advertisement->start_hour = $start_hour;
	    $advertisement->end_hour = $end_hour;
	    $advertisement->lector_id = $id;
	    $advertisement->monday = $monday;
	    $advertisement->tuesday = $tuesday;
	    $advertisement->wednesday = $wednesday;
	    $advertisement->thursday = $thursday;
	    $advertisement->friday = $friday;
	    $advertisement->saturday = $saturday;
	    $advertisement->sunday = $sunday;
	    $advertisement->save();

	    for($i = 0; $i < count($pictures); $i++) {
		    $code = $codes[$i]['code'];
		    /** @var UploadedFile $image */
		    $image = $pictures[$i]['image'];

		    $name = $code.'.'.$image->guessClientExtension();
		    Storage::put(
		    	$name,
			    file_get_contents($image->getRealPath())
		    );

	    	$advertisementPicture = new AdvertisementPictures();
		    $advertisementPicture->advertisement_id = $advertisement->id;
		    $advertisementPicture->code = $code;
		    $advertisementPicture->path = Storage::url($name);
		    $advertisementPicture->description = '';
		    $advertisementPicture->save();
	    }

	    return redirect()->route('app.reports.portico.show', array('id'=>$id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
