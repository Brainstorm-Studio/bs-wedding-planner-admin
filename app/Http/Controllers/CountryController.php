<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function getCountries(){
        try {
            $countries = Country::get()
                ->map(function ($country) {
                    return [
                        'id' => $country->id,
                        'name' => $country->name,
                        'code' => $country->code,
                        'phone_code' => $country->phone_code,
                    ];
                });

            return [
                'data' => $countries,
                'message' => 'Countries fetched successfully'
            ];

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
