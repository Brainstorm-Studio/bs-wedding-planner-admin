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



}
