<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Traits\FlexibleFormatContentModules;
use Illuminate\Http\Request;

class WeddingController extends Controller
{

    use FlexibleFormatContentModules;
    public function getWeddingBySlug($slug)
    {
        $wedding = Wedding::where('slug', $slug)->first();

        if (!$wedding) {
            return response()->json(['message' => 'Wedding not found'], 404);
        }

        $weddingData = collect([
            'wedding' => $wedding->name,
            'wedding_slug' => $wedding->slug,
            'couple_name' => $wedding->couple_name,
            'date' => $wedding->date,
            'location' => $wedding->location,
            'content' => $wedding->content,
            'content_modules' => $this->getContent($wedding->content),
            'main_image' => $wedding->main_image,
            'gallery' => $wedding->gallery
                ->map(function ($item) {
                    return [
                        'gallery_op' => $item->getUrl(),
                    ];
                }),
            'country' => $this->filterCountries($wedding->guests),
            // 'countries' => $wedding->guests
            //     ->map(function ($item) {
            //         return [
            //             'country' => $item->country->name,
            //             'phone_code' => '+'. $item->country->phone_code,
            //         ];
            //     }),
        ]);

        return $weddingData;
    }

    public function filterCountries($data){
        $uniqueCountries = $data;
        return $uniqueCountries->unique('country_id')
            ->map(function ($item) {
                return [
                    'country' => $item->country->name,
                    'phone_code' => '+'. $item->country->phone_code,
                ];
            }) ->sortBy('country')->values();
    }

}
