<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Wedding;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function getGuestsByWedding($slug)
    {
        $wedding = Wedding::where('slug', $slug)->first();

        if (!$wedding) {
            return response()->json(['message' => 'Wedding not found'], 404);
        }

        $guests = Guest::where('wedding_id', $wedding->id)->get();

        $guestData = $guests->map(function ($guest) {
            return [
                'name' => $guest->guest_name,
                'rsvp' => $guest->rsvp,
                'couple' => $guest->couple_name ?? '',
                'email' => $guest->email,
                'phone' => $guest->phone,
                'with_plus_one' => $guest->with_plus_one,
            ];
        });

        return $guestData;
    }

    //get guest by params
    public function getGuestByWeddingAndPhone($slug, $phone)
    {
        $wedding = Wedding::where('slug', $slug)
            ->first();

        $wedding_id = $wedding->id;

        $guest = Guest::where('wedding_id', $wedding_id)
            ->where('phone', $phone)
            ->first();

        if (!$guest) {
            return response()->json(['message' => 'Guest not found'], 404);
        }

        $guestData = [
            'name' => $guest->guest_name,
            'rsvp' => $guest->rsvp,
            'couple' => $guest->couple_name ?? '',
            'email' => $guest->email,
            'phone' => $guest->phone,
            'with_plus_one' => $guest->with_plus_one,
            'plus_one_count' => $guest->plus_one_count,
        ];

        return $guestData;
    }


}
