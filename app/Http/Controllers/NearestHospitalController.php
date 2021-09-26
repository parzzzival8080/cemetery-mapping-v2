<?php

namespace App\Http\Controllers;

use App\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NearestHospitalController extends Controller
{
    public function nearbyHospital(Request $request)
    {

        $latitude = $request->input('lat');
        $longitude = $request->input('lng');
        $radius = 3000;
        $nearbyHospital = Hospital::select('hospitals.*',
                                                DB::raw('((ACOS(SIN(' . $latitude . ' * PI() / 180) * SIN(latitude * PI() / 180) + COS(' . $latitude .
                                                ' * PI() / 180) * COS(latitude * PI() / 180) * COS((' . $longitude . ' - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344 * 1000) AS distance'))
                                                ->orderBy('distance')->having('distance', '<=', $radius)->get();

        return response()->json(
                [
                    'nearby' => $nearbyHospital
                ]
        );
    }
}
